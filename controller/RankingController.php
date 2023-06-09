<?php

class rankingController
{

    /**
     * @param MustacheRender $getRenderer
     * @param RankingModel $param
     */private $renderer;
     private $rankingModel;
    public function __construct( $getRenderer,$param)
    {
        $this->renderer=$getRenderer;
        $this->rankingModel=$param;
    }
    public function list(){
        $data['rankingSolo']= $this->rankingModel->getTop10PorTipoDePartida("1") ;
        $data['rankingBot']= $this->rankingModel->getTop10PorTipoDePartida("2") ;
        $data['rankingPvP']= $this->rankingModel->getTop10PorTipoDePartida("3") ;

        $this->renderer->render('ranking',$data);
    }

}