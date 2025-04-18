<?php 
     
namespace Classes;

class Paginacion{
    public $pagina_actual;
    public $registros_por_pagina;
    public $total_registros;
    public $order;

    public function __construct($pagina_actual = 1, $registros_por_pagina = 10, $total_registros = 0, $order = '')
    {
        $this->pagina_actual = (int) $pagina_actual;
        $this->registros_por_pagina = (int) $registros_por_pagina;
        $this->total_registros = (int) $total_registros;
        $this->order = $order;
    }

    public function offset(){
        return $this->registros_por_pagina * ($this->pagina_actual-1);
    }

    public function total_paginas(){
        return ceil($this->total_registros / $this->registros_por_pagina);
    }

    public function pagina_anterior(){
        $anterior = $this->pagina_actual - 1;
        return ($anterior > 0) ? $anterior : false;

    }

    public function pagina_siguiente(){
        $siguiente = $this->pagina_actual + 1;
        return ($siguiente <= $this->total_paginas()) ? $siguiente : false;

    }

    public function enlace_anterior(){
        $html = '';
        if($this->pagina_anterior()){
            $html .= "<a class=\"paginacion__enlace paginacion__enlace--texto\" href=\"?page={$this->pagina_anterior()}";
            
            if($_GET != [])
            foreach($_GET as $key => $value){
                if ($key != 'page'){
                    $html .= "&{$key}={$value}";
                }
            }
            
            $html .= "\">&laquo; Anterior</a>";
        }

        return $html;

    }

    public function enlace_siguiente(){
        $html = '';
        if($this->pagina_siguiente()){
            $html .= "<a class=\"paginacion__enlace paginacion__enlace--texto\" href=\"?page={$this->pagina_siguiente()}";
            if($_GET != [])
            foreach($_GET as $key => $value){
                if ($key != 'page'){
                    $html .= "&{$key}={$value}";
                }
            }
            $html.= "\">Siguiente &raquo; </a>";
        }

        return $html;
    }

    public function numeros_paginas(){
        $html = '';
            for($i = 1; $i <= $this->total_paginas(); $i++){
                if ($i != $this->pagina_actual){
                    $html.= "<a class=\"paginacion__enlace paginacion__enlace--numero\"  href=\"?page=$i";
                    foreach($_GET as $key => $value){
                        if ($key != 'page'){
                            $html .= "&{$key}={$value}";
                        }
                    }
                    $html.= "\">$i </a>";
                }else{
                    $html.= "<span class=\"paginacion__enlace paginacion__enlace--activo";
                    foreach($_GET as $key => $value){
                        if ($key != 'page'){
                            $html .= "&{$key}={$value}";
                        }
                    }
                    $html.="\">$i </span>";
                }
                
            }

        return $html;
    }

    public function paginacion() {
        $html = '';

        if($this->total_registros > 1){
            $html .= '<div class="paginacion">';
            $html .= $this->enlace_anterior();
            $html .= $this->numeros_paginas();
            $html .= $this->enlace_siguiente();


            $html .= '</div>';
        }


        return $html;
    }
}