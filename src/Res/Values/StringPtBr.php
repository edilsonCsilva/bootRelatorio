<?php

namespace Stilldistribuidora\Res\Values;



class StringPtBr{

    private $resocesDefinitions=[

          'str_title_menu'=>"Operacional Still",
          'str_title_seach'=>"Digite o (Mês e o Ano) Para Pesquisar No Calendário...!",
          'str_detail_operations_date_selected'=>"Ocorrência  da data Selecionada...!",
          'str_detail_operations_date_selected_info'=>"Operações Realizada No Dia Selecionado <b>%s</b>.",
          'str_detail_operations_customens_associated'=>"<b>Clientes Disponiveis</b>.",

         





    ];


    public  function getString($res){
        return $this->resocesDefinitions[$res];
    }


}

?>