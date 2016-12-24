<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ExcelTab
 *
 * @author DG
 */
require_once 'PHPExcel.php';

class ExcelTab {

    static function tabexcel($tab, $titre, $tabtitre, $tabcle, $nomfichier) {


//        $tabcle = explode(';', $listecle);
//        $tabtitre = explode(';', $listetitre);
        $nb = sizeof($tabtitre);
        $j = 1;


        $objPHPExcel = new PHPExcel();

// Set properties
        $objPHPExcel->getProperties()->setCreator("DirectStock")
                ->setLastModifiedBy("DirectStock")
                ->setTitle("Office 2007 XLSX Document")
                ->setSubject("Office 2007 XLSX Document")
                ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                ->setKeywords("office 2007 openxml php")
                ->setCategory("Result file");

        $objRichText = new PHPExcel_RichText();
        $objPayable = $objRichText->createTextRun($titre);
        $objPayable->getFont()->setBold(true);
        $objPayable->getFont()->setItalic(true);
        $objPayable->getFont()->setColor(new PHPExcel_Style_Color(PHPExcel_Style_Color::COLOR_BLACK));

        $j = 'A';
        for ($i = 0; $i < $nb - 1; $i++) {
            $j++;
        }

        $objPHPExcel->getActiveSheet()->getCell('A1')->setValue($objRichText);
        $objPHPExcel->getActiveSheet()->mergeCells('A1:' . $j . '1');

        $k = 'A';
        for ($i = 0; $i < $nb; $i++) {

            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue($k . '2', $tabtitre[$i])
            ;
            $k++;
        }

        $i = 2;

        foreach ($tab as $v):
            $i++;
            $l = 'A';
            for ($m = 0; $m < sizeof($tabcle); $m++) {
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue($l . $i, $v[$tabcle[$m]])
                ;
                $l++;
            }



        endforeach;
        unset($tab);


        $objPHPExcel->getActiveSheet()->setTitle($nomfichier);


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        $m = 'A';
        for ($i = 0; $i < $nb; $i++) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($m)->setWidth(25);
            $m++;
        }
// Redirect output to a clientâ€™s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $nomfichier . '.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }

    //export excel de l'ensemble des differents tableaux
    //
    
static function tabexcelall($tab, $listetitre, $listecle, $nomfichier) {
        $objPHPExcel = new PHPExcel();
        // Set properties
        $objPHPExcel->getProperties()->setCreator("DirectStock")
                ->setLastModifiedBy("DirectStock")
                ->setTitle("Office 2007 XLSX Document")
                ->setSubject("Office 2007 XLSX Document")
                ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                ->setKeywords("office 2007 openxml php")
                ->setCategory("Result file");
        //ligne depart initial
        $i = 1;

        //parcours de chaque tableau associatif avec son titre
        //print_r($tab);
        foreach ($tab as $v) {

            $objPHPExcel = ExcelTab::remplir($v["tab"], $v["titre"], $listetitre, $listecle, $i, $objPHPExcel);
            $i+= count($v["tab"]) + 3;
            //    echo "papa ".$i;
//            echo "<br>";
        }



        //nom de la feuille excel
        $objPHPExcel->getActiveSheet()->setTitle($nomfichier);

        //defini la largeur
        $tabtitre = explode(';', $listetitre);
        $nb = sizeof($tabtitre);
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        $m = 'A';
        for ($dg = 0; $dg < $nb; $dg++) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($m)->setWidth(30);

            $m++;
        }

        //telechargement

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $nomfichier . '.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }

    static function tabexcelall1($tab, $listetitre, $listecle, $nomfichier) {
        $objPHPExcel = new PHPExcel();
        // Set properties
        $objPHPExcel->getProperties()->setCreator("DirectStock")
                ->setLastModifiedBy("DirectStock")
                ->setTitle("Office 2007 XLSX Document")
                ->setSubject("Office 2007 XLSX Document")
                ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                ->setKeywords("office 2007 openxml php")
                ->setCategory("Result file");
        //ligne depart initial
        $i = 1;

        //parcours de chaque tableau associatif avec son titre
        //print_r($tab);
        foreach ($tab as $v) {

            $objPHPExcel = ExcelTab::remplir($v["tab"], $v["titre"], $listetitre, $listecle, $i, $objPHPExcel);
            $i+= count($v["tab"]) + 1;
            //    echo "papa ".$i;
//            echo "<br>";
        }



        //nom de la feuille excel
        $objPHPExcel->getActiveSheet()->setTitle($nomfichier);

        //defini la largeur
        $tabtitre = explode(';', $listetitre);
        $nb = sizeof($tabtitre);
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        $m = 'A';
        for ($dg = 0; $dg < $nb; $dg++) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($m)->setWidth(30);

            $m++;
        }

        //telechargement

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $nomfichier . '.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }

    static function remplir($tab, $titre, $listetitre, $listecle, $lignedepart, $objPHPExcel) {

        $tabcle = explode(';', $listecle);
        $tabtitre = explode(';', $listetitre);
        $nb = sizeof($tabtitre);
        $j = 1;


        //$objPHPExcel = new PHPExcel();



        $objRichText = new PHPExcel_RichText();
        $objPayable = $objRichText->createTextRun($titre);
        $objPayable->getFont()->setBold(true);
        $objPayable->getFont()->setItalic(true);
        $objPayable->getFont()->setColor(new PHPExcel_Style_Color(PHPExcel_Style_Color::COLOR_BLACK));

        $j = 'A';
        for ($i = 0; $i < $nb - 1; $i++) {
            $j++;
        }

        $objPHPExcel->getActiveSheet()->getCell('A' . $lignedepart)->setValue($objRichText);
        $objPHPExcel->getActiveSheet()->mergeCells('A' . $lignedepart . ':' . $j . $lignedepart);

        $k = 'A';
        $lignedepart1 = $lignedepart + 1;
        for ($i = 0; $i < $nb; $i++) {

            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue($k . $lignedepart1, $tabtitre[$i])
            ;
            $k++;
        }

        $i = $lignedepart + 1;

        foreach ($tab as $v):
            $i++;
            $l = 'A';
            for ($m = 0; $m < sizeof($tabcle); $m++) {
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue($l . $i, $v[$tabcle[$m]])
                ;
                $l++;
            }



        endforeach;
        unset($tab);


        return $objPHPExcel;
    }

}

?>
