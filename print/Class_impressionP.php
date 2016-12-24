<?php

if (!isset($_SESSION)) {
    session_start();
}

class PDF extends FPDF {

// En-tête
    function Header() {
        // Logo DirectStock
//        $this->Image('../images/logoimpression.gif', 10, 5, 30, 20);
        //$this->Image('../images/entete.png', 5, 5, 50, 20);
        $this->Image('../images/enteteP.png');
        // Logo Institutions
//        $this->Image('../images/institutions.jpg', 170, 5, 30, 20);
        // Police Arial gras 15
        $this->SetFont('Arial', 'B', 10);
        // D�calage � droite
       // $this->Cell(70);
        $this->Cell(50);
        // Titre du document   
       //$this->Cell(90, 20, utf8_decode($_SESSION['titre']), 0, 0, 'C');
     //  $this->Cell(50, 20, utf8_decode($_SESSION['titre']), 0, 0, 'C');
//         $this->SetFillColor(0, 15, 10);
        $this->SetTextColor(20);
//        $this->SetDrawColor(102, 405, 145);
        $this->MultiCell(200, 5, utf8_decode($_SESSION["titre"]), 0, 'C', FALSE);
        // Saut de ligne
//        $this->Ln(8);
        // D�calage � droite
//        $this->Cell(70);
        // Suite du titre
//        $this->Cell(50, 10, utf8_decode(strtoupper('MATERIELS AU MAEIA')), 0, 0, 'C');
        // Saut de ligne
//        $this->Ln(5);
        // D�calage � droite
//        $this->Cell(80);
        // Saut de ligne
        $this->Ln(5);
//        $this->Cell(0, 10, '', 'B', 0, 'C');
//        $this->Ln(15);
    }

// Pied de page
    function Footer() {
        // Positionnement à 1,5 cm du bas
        $this->SetY(-15);
        // Police Arial italique 8
        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor(0);
        $this->Cell(0, 10, 'Date d\'impression : ' . date('d-m-Y'), 'T', 0, 'L');
        // Numéro de page
        $this->Cell(0, 10, 'Copyright SIPEC-GP -HE SYSTEMS' . date('Y') . ' -- Page ' . $this->PageNo() . '/{nb}', 0, 0, 'R');
    }

    // Tableau de données
    /*
     * $header
     */
    function FancyTable($header, $headerBD, $data, $w, $border = 0, $tabAlign) {
        // Saut de ligne
        $this->Ln(5);
        // Couleurs, épaisseur du trait et police grasse
        $this->SetFillColor(255, 255, 255);
//        $this->SetTextColor(255);
        $this->SetDrawColor(45, 45, 45);
        $this->SetLineWidth(.1);
        $this->SetFont('', 'B');
        // En-tête du tableau  
        // Hauteur max de l'entete du tableau
        $nbl = 0;
        for ($j = 0; $j < count($header); $j++) {
            $nbl = max($nbl, $this->NbLines($w[$j], $header[$j]));
        }
        $hentete = 7 * $nbl;
        for ($i = 0; $i < count($header); $i++) {
            $x = $this->GetX();
            $y = $this->GetY();
            // Dessine le cadre et y imprime le texte centr� horizontalement et verticalement
            $this->drawTextBox(utf8_decode($header[$i]), $w[$i], $hentete, 'L', 'M', $border);
//                
            //Repositionne à droite
            $this->SetXY($x + $w[$i], $y);
//            $this->Cell($w[$i], 7, utf8_decode($header[$i]), 1, 0, 'C', true);
        }

        $this->Ln($hentete);
        // Restauration des couleurs et de la police
        $this->SetTextColor(0);
        $this->SetFont('');
        // Données
        $h = 5; // Hauteur des lignes
        $fill = false;
        foreach ($data as $row) {
            $nblignmax = 0;
            for ($j = 0; $j < count($headerBD); $j++) {
                $nblignmax = max($nblignmax, $this->NbLines($w[$j], $row[$headerBD[$j]]));
            }
            // Calcul de la hauteur max
            $hauteur = $h * $nblignmax;
            //Effectue un saut de page si nécessaire
            $this->CheckPageBreak($hauteur);

            for ($i = 0; $i < count($headerBD); $i++) {
                //Sauve la position courante
                $x = $this->GetX();
                $y = $this->GetY();
                $align = 'L';
                $align = $tabAlign[$i];
                // Dessine le cadre et y imprime le texte centr� horizontalement et verticalement
                if (($row[$headerBD[$i]] == 'Total')) {
                    $this->SetFont('', 'B',10);
                    $this->drawTextBox(utf8_decode($row[$headerBD[$i]]), $w[$i], $hauteur, $align, 'B', $border);
                }  else {
//                    $this->SetFont('', '',10);
                $this->drawTextBox(utf8_decode($row[$headerBD[$i]]), $w[$i], $hauteur, $align, 'M', $border);                    
                }
//                $this->drawTextBox(utf8_decode($row[$headerBD[$i]]), $w[$i], $hauteur, $align, 'M', $border);                    

//                
                //Repositionne � droite
                $this->SetXY($x + $w[$i], $y);
            }
            $this->Ln($hauteur);
            $fill = !$fill;
        }
        // Trait de terminaison
//        $this->Cell(array_sum($w), 0, '', 'T');
    }

    function NbLines($w, $txt) {
        //Calcule le nombre de lignes qu'occupe un MultiCell de largeur w
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 and $s[$nb - 1] == "\n")
            $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ')
                $sep = $i;
            $l+=$cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j)
                        $i++;
                }
                else
                    $i = $sep + 1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            }
            else
                $i++;
        }
        return $nl;
    }

    // Vérification de débordement de rectangle pour un saut de page éventuel
    function CheckPageBreak($h) {
        //Si la hauteur h provoque un d�bordement, saut de page manuel
        if ($this->GetY() + $h > $this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
    }

    // Ecriture d'un texte dans rectangle avec possibilité de centrage horizontal et vertical
    /**
     * Draws text within a box defined by width = w, height = h, and aligns
     * the text vertically within the box ($valign = M/B/T for middle, bottom, or top)
     * Also, aligns the text horizontally ($align = L/C/R/J for left, centered, right or justified)
     * drawTextBox uses drawRows
     *
     * This function is provided by TUFaT.com
     */
    function drawTextBox($strText, $w, $h, $align = 'L', $valign = 'T', $border = 0) {
        $xi = $this->GetX();
        $yi = $this->GetY();

        $hrow = $this->FontSize;
        $textrows = $this->drawRows($w, $hrow, $strText, 0, $align, 0, 0, 0);
        $maxrows = floor($h / $this->FontSize);
        $rows = min($textrows, $maxrows);

        $dy = 0;
        if (strtoupper($valign) == 'M')
            $dy = ($h - $rows * $this->FontSize) / 2;
        if (strtoupper($valign) == 'B')
            $dy = $h - $rows * $this->FontSize;

        $this->SetY($yi + $dy);
        $this->SetX($xi);

        $this->drawRows($w, $hrow, $strText, 0, $align, 0, $rows, 1);

        if ($border == 1)
            $this->Rect($xi, $yi, $w, $h);
    }

    function drawRows($w, $h, $txt, $border = 0, $align = 'J', $fill = 0, $maxline = 0, $prn = 0) {
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 and $s[$nb - 1] == "\n")
            $nb--;
        $b = 0;
        if ($border) {
            if ($border == 1) {
                $border = 'LTRB';
                $b = 'LRT';
                $b2 = 'LR';
            } else {
                $b2 = '';
                if (is_int(strpos($border, 'L')))
                    $b2.='L';
                if (is_int(strpos($border, 'R')))
                    $b2.='R';
                $b = is_int(strpos($border, 'T')) ? $b2 . 'T' : $b2;
            }
        }
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $ns = 0;
        $nl = 1;
        while ($i < $nb) {
            //Get next character
            $c = $s[$i];
            if ($c == "\n") {
                //Explicit line break
                if ($this->ws > 0) {
                    $this->ws = 0;
                    if ($prn == 1)
                        $this->_out('0 Tw');
                }
                if ($prn == 1) {
                    $this->Cell($w, $h, substr($s, $j, $i - $j), $b, 2, $align, $fill);
                }
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $ns = 0;
                $nl++;
                if ($border and $nl == 2)
                    $b = $b2;
                if ($maxline && $nl > $maxline)
                    return substr($s, $i);
                continue;
            }
            if ($c == ' ') {
                $sep = $i;
                $ls = $l;
                $ns++;
            }
            $l+=$cw[$c];
            if ($l > $wmax) {
                //Automatic line break
                if ($sep == -1) {
                    if ($i == $j)
                        $i++;
                    if ($this->ws > 0) {
                        $this->ws = 0;
                        if ($prn == 1)
                            $this->_out('0 Tw');
                    }
                    if ($prn == 1) {
                        $this->Cell($w, $h, substr($s, $j, $i - $j), $b, 2, $align, $fill);
                    }
                } else {
                    if ($align == 'J') {
                        $this->ws = ($ns > 1) ? ($wmax - $ls) / 1000 * $this->FontSize / ($ns - 1) : 0;
                        if ($prn == 1)
                            $this->_out(sprintf('%.3f Tw', $this->ws * $this->k));
                    }
                    if ($prn == 1) {
                        $this->Cell($w, $h, substr($s, $j, $sep - $j), $b, 2, $align, $fill);
                    }
                    $i = $sep + 1;
                }
                $sep = -1;
                $j = $i;
                $l = 0;
                $ns = 0;
                $nl++;
                if ($border and $nl == 2)
                    $b = $b2;
                if ($maxline && $nl > $maxline)
                    return substr($s, $i);
            }
            else
                $i++;
        }
        //Last chunk
        if ($this->ws > 0) {
            $this->ws = 0;
            if ($prn == 1)
                $this->_out('0 Tw');
        }
        if ($border and is_int(strpos($border, 'B')))
            $b.='B';
        if ($prn == 1) {
            $this->Cell($w, $h, substr($s, $j, $i - $j), $b, 2, $align, $fill);
        }
        $this->x = $this->lMargin;
        return $nl;
    }

}

?>