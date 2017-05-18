<?php

class InsightsAPI
{
    private $url;           //URL to test
    private $results;       //results storage
    private $resultsMobile;       //results storage


    public function run(){
        $this->results = $this->getStats('desktop');
        $this->resultsMobile = $this->getStats('mobile');
        if(($this->results!==FALSE) and ($this->resultsMobile!==FALSE)){
            return TRUE;
        }
        return FALSE;
    }
    private function getStats($type){
        if (!filter_var($this->url, FILTER_VALIDATE_URL) === false) {
            $prepare = str_replace('%URL%',urlencode($this->url),Constants::$API_URL);
            $prepare = str_replace('%TYPE%',urlencode($type),$prepare);
            $prepare = str_replace('%KEY%',Constants::$API_KEY,$prepare);
            $info = file_get_contents($prepare);
            $json = json_decode($info,true);
            if($json===FALSE){
                return FALSE;
            }
            if(isset($json['error'])){
                return FALSE;
            }
            //Building response stats
            $results = array();
            $results['title'] = $json['title'];
            $results['score'] = $json['ruleGroups']['SPEED']['score'];
            $results['general'] = array();
            $results['general']['resourcesCount'] = $json['pageStats']['numberResources'];
            $results['general']['hostsCount'] = $json['pageStats']['numberHosts'];
            $results['general']['staticResourcesCount'] = $json['pageStats']['numberStaticResources'];
            $results['general']['jsResourcesCount'] = $json['pageStats']['numberJsResources'];
            $results['general']['cssResourcesCount'] = $json['pageStats']['numberCssResources'];
            $results['general']['totalBytes'] = $json['pageStats']['totalRequestBytes'];
            $results['general']['htmlBytes'] = $json['pageStats']['htmlResponseBytes'];
            $results['general']['cssBytes'] = $json['pageStats']['cssResponseBytes'];
            $results['general']['imageBytes'] = $json['pageStats']['imageResponseBytes'];
            $results['general']['jsBytes'] = $json['pageStats']['javascriptResponseBytes'];
            $results['general']['otherBytes'] = $json['pageStats']['otherResponseBytes'];
            $results['rules'] = array('ok'=>array(),'failed'=>array());
            foreach ($json['formattedResults']['ruleResults'] as $rule=>$score){
                if($score['ruleImpact']>0){
                    $results['rules']['failed'][$rule] = array('desc'=>$score['localizedRuleName'],'score'=>$score['ruleImpact']);
                }else{
                    $results['rules']['ok'][$rule] = array('desc'=>$score['localizedRuleName'],'score'=>$score['ruleImpact']);
                }
            }
            return $results;
        }else{
            return FALSE;
        }
    }
    public function toObject(){
        $output = array();
        if($this->results!==FALSE){
            $output[] = $this->getParamInfo("Desktop Total Requests Count",$this->results['general']['resourcesCount'],100,"decrease required",3.25,"$");
            $output[] = $this->getParamInfo("Desktop Static Resources",$this->results['general']['staticResourcesCount'],100,"decrease required",3.25,"$");
            $output[] = $this->getParamInfo("Desktop JS Resources",$this->results['general']['jsResourcesCount'],10,"decrease required",3.25,"$");
            $output[] = $this->getParamInfo("Desktop CSS Resources",$this->results['general']['cssResourcesCount'],10,"decrease required",3.25,"$");

            $output[] = $this->getParamInfo("Desktop Page Weight",$this->results['general']['totalBytes'],5*1024*1024,"decrease required",3.25,"$");
            $output[] = $this->getParamInfo("Desktop HTML Weight",$this->results['general']['htmlBytes'],0.5*1024*1024,"decrease required",3.25,"$");
            $output[] = $this->getParamInfo("Desktop CSS Weight",$this->results['general']['cssBytes'],0.5*1024*1024,"decrease required",3.25,"$");
            $output[] = $this->getParamInfo("Desktop JS Weight",$this->results['general']['jsBytes'],0.5*1024*1024,"decrease required",3.25,"$");
            $output[] = $this->getParamInfo("DImages Weight",$this->results['general']['imageBytes'],3*1024*1024,"decrease required",3.25,"$");
            $output[] = $this->getParamInfo("Desktop Other Content Weight",$this->results['general']['otherBytes'],0.5*1024*1024,"decrease required",3.25,"$");
            foreach($this->results['rules']['ok'] as $key=>$info){
                $output[]=array('key'=>'Desktop'.str_replace(' ','',$info['desc']),'name'=>$info['desc'],'price'=>0,'currency'=>'$','comment'=>'-','status'=>'OK');
            }
            foreach($this->results['rules']['failed'] as $key=>$info){
                $output[]=array('key'=>'Desktop'.str_replace(' ','',$info['desc']),'name'=>$info['desc'],'price'=>4.1,'currency'=>'$','comment'=>'decrease required','status'=>'FAILED');
            }

        }
        if($this->resultsMobile!==FALSE){
            $output[] = $this->getParamInfo("Mobile Total Requests Count",$this->resultsMobile['general']['resourcesCount'],100,"decrease required",2.25,"$");
            $output[] = $this->getParamInfo("Mobile Static Resources",$this->resultsMobile['general']['staticResourcesCount'],100,"decrease required",2.25,"$");
            $output[] = $this->getParamInfo("Mobile JS Resources",$this->resultsMobile['general']['jsResourcesCount'],10,"decrease required",2.25,"$");
            $output[] = $this->getParamInfo("Mobile CSS Resources",$this->resultsMobile['general']['cssResourcesCount'],10,"decrease required",2.25,"$");

            $output[] = $this->getParamInfo("Mobile Page Weight",$this->resultsMobile['general']['totalBytes'],5*1024*1024,"decrease required",5.25,"$");
            $output[] = $this->getParamInfo("Mobile HTML Weight",$this->resultsMobile['general']['htmlBytes'],0.5*1024*1024,"decrease required",5.25,"$");
            $output[] = $this->getParamInfo("Mobile CSS Weight",$this->resultsMobile['general']['cssBytes'],0.5*1024*1024,"decrease required",5.25,"$");
            $output[] = $this->getParamInfo("Mobile JS Weight",$this->resultsMobile['general']['jsBytes'],0.5*1024*1024,"decrease required",5.25,"$");
            $output[] = $this->getParamInfo("Mobile Weight",$this->resultsMobile['general']['imageBytes'],1*1024*1024,"decrease required",5.25,"$");
            $output[] = $this->getParamInfo("Mobile Other Content Weight",$this->resultsMobile['general']['otherBytes'],0.5*1024*1024,"decrease required",5.25,"$");
            foreach($this->resultsMobile['rules']['ok'] as $key=>$info){
                $output[]=array('key'=>'Mobile'.str_replace(' ','','Mobile: '.$info['desc']),'name'=>$info['desc'],'price'=>0,'currency'=>'$','comment'=>'-','status'=>'OK');
            }
            foreach($this->resultsMobile['rules']['failed'] as $key=>$info){
                $output[]=array('key'=>'Mobile'.str_replace(' ','',$info['desc']),'name'=>'Mobile: '.$info['desc'],'price'=>2.1,'currency'=>'$','comment'=>'decrease required','status'=>'FAILED');
            }
        }
    }
    private function getParamInfo($name,$score,$limit,$comment,$price,$curreny){
        $status = 'OK';
        if($score<$limit){
            $price=0;
            $comment='';
            $status='FAILED';
        }
        return array('key'=>str_replace(' ','',$name),'name'=>$name,'price'=>$price,'currency'=>$curreny,'comment'=>$comment,'status'=>$status);
    }
    public function toPDF(){
        $fileName = $string = preg_replace("/[^ \w]+/", "", $this->url).'.'.date('YmdH').'.pdf';
        $pdf = new PDFCreator($this->url);
        $pdf->AliasNbPages();
        $pdf->AddPage();
        if($this->results!==FALSE){
            $pdf->ChapterTitle("Overall Stats for Desctop devices");
            $pdf->printTopParam("Total Requests Count",$this->results['general']['resourcesCount'],100,"decrease required");
            $pdf->printTopParam("Static Resources",$this->results['general']['staticResourcesCount'],100,"decrease required");
            $pdf->printTopParam("JS Resources",$this->results['general']['jsResourcesCount'],10,"decrease required");
            $pdf->printTopParam("CSS Resources",$this->results['general']['cssResourcesCount'],10,"decrease required");
            $pdf->Ln();
            $pdf->Ln();
            $pdf->printTopParam("Page Weight",$this->results['general']['totalBytes'],5*1024*1024,"decrease required",true);
            $pdf->printTopParam("HTML Weight",$this->results['general']['htmlBytes'],0.5*1024*1024,"decrease required",true);
            $pdf->printTopParam("CSS Weight",$this->results['general']['cssBytes'],0.5*1024*1024,"decrease required",true);
            $pdf->printTopParam("JS Weight",$this->results['general']['jsBytes'],0.5*1024*1024,"decrease required",true);
            $pdf->printTopParam("Images Weight",$this->results['general']['imageBytes'],3*1024*1024,"decrease required",true);
            $pdf->printTopParam("Other Content Weight",$this->results['general']['otherBytes'],0.5*1024*1024,"decrease required",true);

            $pdf->ChapterTitle("Speed test for Desctop devices");
            foreach($this->results['rules']['ok'] as $key=>$info){
                $pdf->printStatParam($info['desc'],'OK',0);
            }
            foreach($this->results['rules']['failed'] as $key=>$info){
                $pdf->printStatParam($info['desc'],'FAILED',$info['score'],"Speed decrease ".round($info['score'],2)."%");
            }
        }
        if($this->resultsMobile!==FALSE){
            $pdf->ChapterTitle("Overall Stats for Mobile devices");
            $pdf->printTopParam("Total Requests Count",$this->results['general']['resourcesCount'],100,"decrease required");
            $pdf->printTopParam("Static Resources",$this->results['general']['staticResourcesCount'],100,"decrease required");
            $pdf->printTopParam("JS Resources",$this->results['general']['jsResourcesCount'],10,"decrease required");
            $pdf->printTopParam("CSS Resources",$this->results['general']['cssResourcesCount'],100,"decrease required");
            $pdf->Ln();
            $pdf->Ln();
            $pdf->printTopParam("Page Weight",$this->results['general']['totalBytes'],5*1024*1024,"decrease required",true);
            $pdf->printTopParam("HTML Weight",$this->results['general']['htmlBytes'],0.5*1024*1024,"decrease required",true);
            $pdf->printTopParam("CSS Weight",$this->results['general']['cssBytes'],0.5*1024*1024,"decrease required",true);
            $pdf->printTopParam("JS Weight",$this->results['general']['jsBytes'],0.5*1024*1024,"decrease required",true);
            $pdf->printTopParam("Images Weight",$this->results['general']['imageBytes'],3*1024*1024,"decrease required",true);
            $pdf->printTopParam("Other Content Weight",$this->results['general']['otherBytes'],0.5*1024*1024,"decrease required",true);

            $pdf->ChapterTitle("Speed test for Mobile devices");
            foreach($this->resultsMobile['rules']['ok'] as $key=>$info){
                $pdf->printStatParam($info['desc'],'OK',0);
            }
            foreach($this->resultsMobile['rules']['failed'] as $key=>$info){
                $pdf->printStatParam($info['desc'],'FAILED',$info['score'],"Speed decrease ".round($info['score'],2)."%");
            }
        }

        $pdf->Output('F',MAIN_DOMAIN.Constants::$PDF_SAVE_PATH.$fileName);
        return true;
    }
    public function checkReportCache(){
        $fileName = $string = preg_replace("/[^ \w]+/", "", $this->url).'.'.date('YmdH').'.pdf';
        if(!file_exists(MAIN_DOMAIN.Constants::$PDF_SAVE_PATH.$fileName)){
            return false;
        }
        return true;
    }
    public function downloadPDFReport(){
        $fileName = $string = preg_replace("/[^ \w]+/", "", $this->url).'.'.date('YmdH').'.pdf';
        if(file_exists(MAIN_DOMAIN.Constants::$PDF_SAVE_PATH.$fileName)){
            header('Content-type: application/pdf');
            header('Content-Disposition: attachment; filename="url_report.'.date('YmdH').'.pdf"');
            readfile(MAIN_DOMAIN.Constants::$PDF_SAVE_PATH.$fileName);
        }
    }

    /**
     * @return mixed
     */
    public function getResults()
    {
        return $this->results;
    }

    /**
     * @param mixed $results
     */
    public function setResults($results)
    {
        $this->results = $results;
    }

    /**
     * InsightsAPI constructor.
     * @param $url
     */
    public function __construct($url)
    {
        $this->url = $url;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }


}