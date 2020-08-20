<?php

namespace App\Controller;

use App\Entity\Upload;
use Propel\Runtime\Propel;
use App\Models\EmployeQuery;
use App\Form\UploadExcelType;
use App\Services\UploadService;
use App\Services\GeneralService;
use Propel\Runtime\Map\TableMap;
use App\Models\Map\EmployeTableMap;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class TargetController extends AbstractController
{

    /**
     * @Route("/target-import", name="target-import", methods="POST")
     *
     */
    public function targetimport(Request $request) : Response
    {
        $upload = new Upload();
        $form = $this->createForm(UploadExcelType::class, $upload);
        $form->handleRequest($request);

        
        
        if ($form->isSubmitted() && $form->isValid()) {
            $params = $request->request->all();
            if(!array_key_exists("target", $params)){
                $this->addFlash("error", "Cible d'import non spécifié");
                return $this->redirect($request->headers->get('referer'));
            }
            $brochureFile = $form->get('data')->getData();
            if ($brochureFile) {
                // try {
                    $target = $params['target'];
                    $worksheet = $form->getData("worksheet")->getWorkSheet();
                    $uploadService = new UploadService();
                    $listReference = [];
                    if($target == "pointage"){
                        $listReference = EmployeQuery::create()
                        ->withColumn("employe_id")
                        ->withColumn("employe_pointage_id")
                        ->select("employe_id", "employe_pointage_id")
                        ->find();
                    }
                    $listReference = GeneralService::collectionToArray($listReference);
                    // dump($listReference);
                    
                    
                    $targetData = $uploadService->importFile($brochureFile->getRealPath(), $target, $worksheet,$listReference);
                    throw new Exception("Error Processing Request", 1);
                    $this->addFlash("success", "Succès de l'importation du fichier");
                    return $this->redirectToRoute("target-list", [
                        'target' =>$target
                    ]);
                // } catch (\Throwable $th) {
                    // $this->addFlash("error", "Une erreur est survenue lors de l'import :" . $th->getMessage());
                // }
            }
        }

        return $this->redirectToRoute("target-list");
    }

    /**
     * @Route("/target-new", name="target-new")
     */
    public function targetnew(Request $request) : Response
    {
        $params = $request->query->all();
        $previous = $request->headers->get('referer');
        if (!array_key_exists("target", $params)) {
            $this->addFlash("error", "Cible de création non spécifié");
            
            return $this->redirectToRoute("targetlist");
        }
        $targetname = $params["target"];
        
        $muteFields = $this->getMuteFields($params, $previous);

        if (!GeneralService::hasAccessToThis($this->getUser(), $muteFields)) {
            throw new AccessDeniedException("Vous n'avez pas l'autorisation de faire cette action");
        }
        $target = GeneralService::invokeExtension($targetname);
        $title = $targetname;
        if (method_exists($target, "getTitle")) {
            $title = $target->getTitle();
        }
        $this->addPreAddData($params, $target);
        $keyCrud = $target->keyCrud();
        $builder = $this->createFormBuilder($target);
        $this->addInputToFormBuilder($builder, $keyCrud, $target, true);
        $form = $builder->getForm();
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            // data is an array with "name", "email", and "message" keys
            $data = $form->getData();
            $con =  Propel::getWriteConnection(EmployeTableMap::DATABASE_NAME);
            $allData = $request->request->all();
            $this->injectMuteData($data, $allData);
            $data->save($con);
            
            // $this->saveUploadFile($data, $form, $targetname);
            $data->save($con);
            $this->addFlash("success", "Succès ajout $targetname");
            $redirect_link = "targetlist";
            if (array_key_exists("redirect", $allData)) {
                $redirect_link = $allData["redirect"];
            }

            if (array_key_exists("addmore", $allData['form']) && $allData['form']['addmore']) {
                return $this->redirect($request->headers->get('referer'));
            }
            return $this->redirect($redirect_link);
        }
        return $this->render("pages/target/new.html.twig", [
            "form_title" => "Ajouter un $targetname",
            "target" => $targetname,
            "mute" => $muteFields,
            "title" => $title,
            "form" => $form->createView(),
        ]);
    }

    /**
     * @Route("/target-edit", name="target-edit", methods="GET")
     */
    public function targetedit(Request $request) : Response
    {
    }

    /**
     * @Route("/target-delete", name="target-delete", methods="GET")
     */
    public function targetdelete(Request $request) : Response
    {
    }

    /**
     * @Route("/target-list", name="target-list", methods="GET")
     */
    public function targetlist(Request $request) : Response
    {
        $params = $request->query->all();
        !array_key_exists("target", $params)? $params["target"] = "employe" : null;
        $targetname = $params["target"];
        if (!GeneralService::isTargetOk($params)) {
            $params["target"] = "osc";
        }

        $target = GeneralService::invokeExtension($targetname);
        $query = GeneralService::invokeExtension($targetname . "_query");
        $mode = null;
        if (array_key_exists("mode", $params)) {
            $mode = $params['mode'];
        }
        if (method_exists($target, "joinOtherColummns")) {
            $target->joinOtherColummns($query, $mode);
        }
        $keys = !method_exists($target, "getKeyToShow")? array_keys($target->toArray(TableMap::TYPE_FIELDNAME)) : $target->getKeyToShow($mode);
        $keyText = !method_exists($target, "getKeyText")? $keys : $target->getKeyText($mode);

        $results = GeneralService::getResults($query, $params, $targetname);
        // dump($results);
        $pagenumber = round($results['count'] / $params['limit'], 0);
        if ($results['count'] % $params['limit'] > 0) {
            $pagenumber ++;
        }
        if ($pagenumber == 0) {
            $pagenumber = 1;
        }

        $breakStart = 0;
        $breakEnd = 0;
        if ($pagenumber > 5) {
            $breakStart = 3;
            $breakEnd = $pagenumber - 2;
        }


        $keySearch = [];
        if (method_exists($target, "getKeySearch")) {
            $keySearch = $target->getKeySearch($mode);
        }

        $title = $targetname . "s";
        if (method_exists($target, "getTitle")) {
            $title = $target->getTitle($mode);
        }

        $orderByList = GeneralService::createOrderByList($keySearch);

        $upload = new Upload();
        $form = $this->createForm(UploadExcelType::class, $upload, [
                'action' => $this->generateUrl('target-import')
        ]);
     
        $actualPage = $params['page'];
        unset($params['page']);


        $pagenew = "target-new";
        $pageedit = "target-edit";
        $pagedelete ="target-delete";
        $pagedetail = "target-delete";

        if (array_key_exists('pagenew', $params)) {
            $pagenew = $params['pagenew'];
        }
        if (array_key_exists('pagedetail', $params)) {
            $pagedetail = $params['pagedetail'];
        }
        if (array_key_exists('pageedit', $params)) {
            $pageedit = $params['pageedit'];
        }
        if (array_key_exists('pagedelete', $params)) {
            $pagedelete = $params['pagedelete'];
        }
        $back =  $request->headers->get('referer');
        $redirect = "/target-list?target=$targetname";
        $paramsData = [
            "search" =>$keySearch,
            "back" =>$back,
            "redirect" =>$redirect,
            "title" =>$title,
            "count" => $results['count'],
            "results" => $results[$targetname.'s'],
            'pagenumber' => $pagenumber,
            'breakstart' => $breakStart,
            'breakend' => $breakEnd,
            'actualpage' => $actualPage,
            "keys" => $keys,
            "keyText" => $keyText,
            "target" => $targetname,
            "target_id" =>$targetname . "_id",
            "pagedetail" =>$pagedetail,
            "pageedit" =>$pageedit,
            "pagenew" =>$pagenew,
            "pagedelete" =>$pagedelete,
            "oldparams" => http_build_query($params),
            "oldparamsArray" => $params,
            "orderby" =>$orderByList,
            "form" =>$form->createView(),
            "mode" =>$mode
        ];
        return $this->render("pages/target/list.html.twig", $paramsData);
    }

    public function getMuteFields($params, $defaultRedirect = null)
    {
        $return = [];
        if (!array_key_exists("mute", $params)) {
            return [
                "redirect" => $defaultRedirect
            ];
        }
        
        return json_decode(urldecode($params["mute"]), true);
    }

    public function addPreAddData($params, &$target)
    {
        if (array_key_exists("pre_add", $params)) {
            foreach ($params["pre_add"] as $key => $value) {
                $setter = 'set' . GeneralService::getFieldName($key);
                if (method_exists($target, $setter)) {
                    $target->$setter($value);
                }
            }
        }
    }

    public function addInputToFormBuilder(&$builder, $keyCrud, $target, $is_new = false)
    {
        foreach ($keyCrud as $key => $oneElement) {
            $type = $this->generateType($oneElement);
            $options = $this->generateOptions($oneElement);
            $builder->add($oneElement['path'], $type, $options);
        }
        if ($is_new && method_exists($target, "getAddMore")) {
            $builder->add('addmore', CheckboxType::class, [
                'label'    => 'Ajouter un nouveau après sauvegarde',
                'required' => false,
            ]);
        }
        $builder->add('Enregistrer', SubmitType::class);
    }

    public function generateType($element)
    {
        $type = TextType::class;
        if (!array_key_exists("type", $element)) {
            return $type;
        }
        switch ($element["type"]) {
            case 'select':
                $type = ChoiceType::class;
                break;
            case 'date':
                $type = DateType::class;
                break;
            case 'file':
                $type = FileType::class;
                break;
            case 'number':
                $type = NumberType::class;
                break;
            case 'datetime':
                    $type = DateTimeType::class;
                    break;
            default:
                # code...
                break;
        }
        return $type;
    }

    public function generateOptions($element)
    {
        $options = [];
        $options['label'] = $element['key'];
        $options["required"] = false;

        if (array_key_exists("type", $element)) {
            if ($element['type'] == "select") {
                $options["choices"] = $element["value"];
            }
        }
        if (array_key_exists("type", $element)) {
            if ($element['type'] == "date") {
                $options["widget"] = "single_text";
            }
            if ($element['type'] == "datetime") {
                $options["widget"] = "single_text";
                $options["input"] = "datetime";
            }
        }
        if (array_key_exists("required", $element)) {
            if ($element['required']) {
                $options["required"] = true;
            }
        }
        
        return $options;
    }

    public function injectMuteData(&$data, $allRequestData)
    {
        unset($allRequestData['form']);
        foreach ($allRequestData as $key => $oneMuteValue) {
            $func = "set" . GeneralService::getFieldName($key);
            if (method_exists($data, $func)) {
                $data->$func($oneMuteValue);
            }
        }
    }
}
