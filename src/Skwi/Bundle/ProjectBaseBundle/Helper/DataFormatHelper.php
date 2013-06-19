<?php

namespace Skwi\Bundle\ProjectBaseBundle\Helper;

class DataFormatHelper
{
    public static function lastnameFormat($string)
    {
        return strtoupper($string);
    }

    public static function firstnameFormat($string)
    {
        return  ucfirst(strtolower($string));
    }

    public static function phoneNumberFormat($num, $sep=" ")
    {
        if (strlen($num) == 10)
            return chunk_split($num, 2, $sep);
        else
            return $num;
    }

    /**
    * fonction permettant de transformer une valeur numérique en valeur en lettre
    * @param int $Nombre le nombre a convertir
    * @param int $Devise (0 = aucune, 1 = Euro €, 2 = Dollar $)
    * @param int $Langue (0 = Français, 1 = Belgique, 2 = Suisse)
    * @return string la chaine
    */
    public static function ConvNumberLetter($Nombre, $Devise = 0, $Langue = 0)
    {
        $dblEnt=''; $byDec='';
        $bNegatif='';
        $strDev = '';
        $strCentimes = '';

        if ($Nombre < 0) {
            $bNegatif = true;
            $Nombre = abs($Nombre);

        }
        $dblEnt = intval($Nombre) ;
        $byDec = round(($Nombre - $dblEnt) * 100) ;
        if ($byDec == 0) {
            if ($dblEnt > 999999999999999) {
                return "#TropGrand" ;
            }
        } else {
            if ($dblEnt > 9999999999999.99) {
                return "#TropGrand" ;
            }
        }
        switch ($Devise) {
            case 0 :
            if ($byDec > 0) $strDev = " virgule" ;
            break;
            case 1 :
            $strDev = " Euro" ;
            if ($byDec > 0) $strCentimes = $strCentimes . " Cents" ;
            break;
            case 2 :
            $strDev = " Dollar" ;
            if ($byDec > 0) $strCentimes = $strCentimes . " Cent" ;
            break;
        }
        if (($dblEnt > 1) && ($Devise != 0)) $strDev = $strDev . "s" ;

        $NumberLetter = DataFormatHelper::ConvNumEnt(floatval($dblEnt), $Langue) . $strDev . " " . DataFormatHelper::ConvNumDizaine($byDec, $Langue) . $strCentimes ;

        return $NumberLetter;
    }

    private static function ConvNumEnt($Nombre, $Langue = 0)
    {
        if ($Nombre == 0) {
            return 'zero';
        }

        $byNum=$iTmp=$dblReste='' ;
        $StrTmp = '';
        $NumEnt='' ;
        $iTmp = $Nombre - (intval($Nombre / 1000) * 1000) ;
        $NumEnt = DataFormatHelper::ConvNumCent(intval($iTmp), $Langue) ;
        $dblReste = intval($Nombre / 1000) ;
        $iTmp = $dblReste - (intval($dblReste / 1000) * 1000) ;
        $StrTmp = DataFormatHelper::ConvNumCent(intval($iTmp), $Langue) ;
        switch ($iTmp) {
            case 0 :
            break;
            case 1 :
            $StrTmp = "mille " ;
            break;
            default :
            $StrTmp = $StrTmp . " mille " ;
        }
        $NumEnt = $StrTmp . $NumEnt ;
        $dblReste = intval($dblReste / 1000) ;
        $iTmp = $dblReste - (intval($dblReste / 1000) * 1000) ;
        $StrTmp = DataFormatHelper::ConvNumCent(intval($iTmp), $Langue) ;
        switch ($iTmp) {
            case 0 :
            break;
            case 1 :
            $StrTmp = $StrTmp . " million " ;
            break;
            default :
            $StrTmp = $StrTmp . " millions " ;
        }
        $NumEnt = $StrTmp . $NumEnt ;
        $dblReste = intval($dblReste / 1000) ;
        $iTmp = $dblReste - (intval($dblReste / 1000) * 1000) ;
        $StrTmp = DataFormatHelper::ConvNumCent(intval($iTmp), $Langue) ;
        switch ($iTmp) {
            case 0 :
            break;
            case 1 :
            $StrTmp = $StrTmp . " milliard " ;
            break;
            default :
            $StrTmp = $StrTmp . " milliards " ;
        }
        $NumEnt = $StrTmp . $NumEnt ;
        $dblReste = intval($dblReste / 1000) ;
        $iTmp = $dblReste - (intval($dblReste / 1000) * 1000) ;
        $StrTmp = DataFormatHelper::ConvNumCent(intval($iTmp), $Langue) ;
        switch ($iTmp) {
            case 0 :
            break;
            case 1 :
            $StrTmp = $StrTmp . " billion " ;
            break;
            default :
            $StrTmp = $StrTmp . " billions " ;
        }
        $NumEnt = $StrTmp . $NumEnt ;

        return $NumEnt;
    }

    private static function ConvNumDizaine($Nombre, $Langue = 0)
    {
        $TabUnit=$TabDiz='';
        $byUnit=$byDiz='' ;
        $strLiaison = '' ;

        $TabUnit = array("", "un", "deux", "trois", "quatre", "cinq", "six", "sept",
            "huit", "neuf", "dix", "onze", "douze", "treize", "quatorze", "quinze",
            "seize", "dix-sept", "dix-huit", "dix-neuf") ;
        $TabDiz = array("", "", "vingt", "trente", "quarante", "cinquante",
            "soixante", "soixante", "quatre-vingt", "quatre-vingt") ;
        if ($Langue == 1) {
            $TabDiz[7] = "septante" ;
            $TabDiz[9] = "nonante" ;
        } elseif ($Langue == 2) {
            $TabDiz[7] = "septante" ;
            $TabDiz[8] = "huitante" ;
            $TabDiz[9] = "nonante" ;
        }
        $byDiz = intval($Nombre / 10) ;
        $byUnit = $Nombre - ($byDiz * 10) ;
        $strLiaison = "-" ;
        if ($byUnit == 1) $strLiaison = " et " ;
        switch ($byDiz) {
            case 0 :
            $strLiaison = "" ;
            break;
            case 1 :
            $byUnit = $byUnit + 10 ;
            $strLiaison = "" ;
            break;
            case 7 :
            if ($Langue == 0) $byUnit = $byUnit + 10 ;
            break;
            case 8 :
            if ($Langue != 2) $strLiaison = "-" ;
            break;
            case 9 :
            if ($Langue == 0) {
                $byUnit = $byUnit + 10 ;
                $strLiaison = "-" ;
            }
            break;
        }
        $NumDizaine = $TabDiz[$byDiz] ;
        if ($byDiz == 8 && $Langue != 2 && $byUnit == 0) $NumDizaine = $NumDizaine . "s" ;
        if ($TabUnit[$byUnit] != "") {
            $NumDizaine = $NumDizaine . $strLiaison . $TabUnit[$byUnit] ;
        } else {
            $NumDizaine = $NumDizaine ;
        }

        return $NumDizaine;
    }

    private static function ConvNumCent($Nombre, $Langue = 0)
    {
        $TabUnit='' ;
        $byCent=$byReste='' ;
        $strReste = '' ;
        $NumCent='';
        $TabUnit = array("", "un", "deux", "trois", "quatre", "cinq", "six", "sept","huit", "neuf", "dix") ;

        $byCent = intval($Nombre / 100) ;
        $byReste = $Nombre - ($byCent * 100) ;
        $strReste = DataFormatHelper::ConvNumDizaine($byReste, $Langue);
        switch ($byCent) {
            case 0 :
            $NumCent = $strReste ;
            break;
            case 1 :
            if ($byReste == 0)
                $NumCent = "cent" ;
            else
                $NumCent = "cent " . $strReste ;
            break;
            default :
            if ($byReste == 0)
                $NumCent = $TabUnit[$byCent] . " cents" ;
            else
                $NumCent = $TabUnit[$byCent] . " cent " . $strReste ;
        }

        return $NumCent;
    }

}