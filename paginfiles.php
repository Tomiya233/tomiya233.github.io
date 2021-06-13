<?php
// Trennzeichem zwischen den Links
$bl_delimeter = ' ';

//Anzahl Seitenlinks, am besten eine ungerade Zahl
$bl_anzahllinks = 7;

// Name der Datei in der geblättert wird
$bl_file = 'files.php?start=';

//Bezeichner für Link
$bl_link = '[<a href="{$bl_file}{$i}">{$i}</a>]';

//Bezeichner für aktiven Link
$bl_link_aktiv = '({$i})';

//Bezeichner zum Anfang
$bl_anfang = '[<a href="{$bl_file}{$i}">&laquo;</a>]';

// Bezeichner zurück
$bl_zurueck = ' [<a href="{$bl_file}{$i}">&#8249;</a>] ';

//Bezeichner zum Ende
$bl_ende = ' [<a href="{$bl_file}{$i}">&raquo;</a>]';

// Bezeichner vor
$bl_vor = ' [<a href="{$bl_file}{$i}" >&#8250;</a>]';


/*
        ***********************

        Ab hier keine Änderungen mehr vornehmen

        ***********************
*/
class blaetter{

                var $seiten = 0;
                var $start = 1;
                var $navbar = '';

                function nav($bl_gesamt,$bl_aktuell){
                        $this->gesamt = $bl_gesamt;
                        $this->seiten();
                        $this->aktuell = $bl_aktuell > $this->seiten ? false : $bl_aktuell;
                        $this->start();
                        $this->anfang();
                        $this->links();
                        $this->ende();
                        return $this->navbar;
                }

                function seiten(){
                        global $bl_anzeige;
                        $this->seiten = ceil($this->gesamt/$bl_anzeige);
                        return true;
                }

                function start(){
                        global $bl_anzahllinks;
                        if($this->seiten > $bl_anzahllinks){
                                $start_pos = $this->aktuell-floor($bl_anzahllinks/2);
                                if($start_pos > ($this->seiten-$bl_anzahllinks))
                                        $this->start = $this->seiten-$bl_anzahllinks+1;
                                elseif($start_pos > 1)
                                        $this->start = $start_pos;
                        }
                }

                function links(){
                        global $bl_delimeter,$bl_link,$bl_link_aktiv,$bl_file,$bl_delimeter,$bl_anzahllinks;
                        $ende = $bl_anzahllinks > $this->seiten ? $this->seiten : $bl_anzahllinks  ;
                        for($i=$this->start;$i < $ende+$this->start;$i++){
                                if($this->aktuell == $i)
                                        eval ("\$this->navbar .= \"".$this->adds($bl_link_aktiv)."\";");
                                else
                                        eval ("\$this->navbar .= \"".$this->adds($bl_link)."\";");
                                if(($i >= $this->start && $i < $bl_anzahllinks+$this->start-1) && $this->seiten > 1)
                                        eval ("\$this->navbar .= \"".$this->adds($bl_delimeter)."\";");
                        }
                }

                function anfang(){
                        global $bl_anfang,$bl_zurueck,$bl_file,$bl_anzahllinks;
                        if($this->seiten > $bl_anzahllinks && $this->start > 1){
                                $i = 1;
                                eval ("\$this->navbar .= \"".$this->adds($bl_anfang)."\";");
                        }
                        if($this->aktuell != 1){
                                $i = $this->aktuell-1;
                                eval ("\$this->navbar .= \"".$this->adds($bl_zurueck)."\";");
                        }
                }

                function ende(){
                        global $bl_vor,$bl_ende,$bl_file,$bl_anzahllinks;
                        if($this->aktuell != $this->seiten){
                                $i = $this->aktuell+1;
                                eval ("\$this->navbar .= \"".$this->adds($bl_vor)."\";");
                        }
                        if($this->seiten > $bl_anzahllinks){
                                $i = $this->seiten;
                                eval ("\$this->navbar .= \"".$this->adds($bl_ende)."\";");
                        }
                }

                function adds($text){
                        return addslashes($text);
                }
}
$bl = new blaetter();
?>