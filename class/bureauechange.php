<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of bureaux
 *
 * @author FIDELE
 */
class bureauechange {

    //put your code here
    var $id;
    var $codeunique;
    var $idlocalite;
    var $designation;
    var $idcreateur;
    
    public function __construct($codeunique){
        $rekete = "select * from bureauechange where codeunique = '" . $codeunique . "'";
        $result = Functions::commit_sql($rekete,"");
        
        if ($result){
            
            $list = $result-> fetch();
            $this->id = $list["id"];
            $this->codeunique = $list["codeunique"];
            $this->idlocalite = $list["idlocalite"];
            $this->designation = $list["designation"];
            $this->idcreateur = $list["idcreateur"];
                       
        }
        
    }
   
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getCodeunique() {
        return $this->codeunique;
    }

    public function setCodeunique($codeunique) {
        $this->codeunique = $codeunique;
    }

    public function getIdlocalite() {
        return $this->idlocalite;
    }

    public function setIdlocalite($idlocalite) {
        $this->idlocalite = $idlocalite;
    }

    public function getDesignation() {
        return $this->designation;
    }

    public function setDesignation($designation) {
        $this->designation = $designation;
    }

    public function getIdcreateur() {
        return $this->idcreateur;
    }

    public function setIdcreateur($idcreateur) {
        $this->idcreateur = $idcreateur;
    }

        
    public static function designationBureau($idbur){
        $b = new bureauechange($idbur);
        return $b->getDesignation();
    }

    public function verifDoublon(){
      $rekete = "select * from bureauechange where designation = '" . $this->designation ."' AND idlocalite = '" . $this->idlocalite ."'";
      $result = Functions::commit_sql($rekete,"");
      $retour = FALSE;
      if($result){
          $ls = $result->fetch();
          if($ls['id'] !='')
              $retour = TRUE;
      }
      return $retour;
    }
    
    public function ajoutBureauechange(){
        if(!$this->verifDoublon()){
            if($this->codeunique== '')
                $this->codeunique = principale::initCodeunique (gethostname (), 'codeunique', 'bureauechange');
               $rekete = "insert into bureauechange(codeunique, idlocalite,designation, idcreateur)";
               $rekete .= "VALUES( '" .$this->codeunique ."', '" .$this->idlocalite ."', '" .$this->designation ."', '" . $_SESSION['user']['codeunique'] . "')";
               $result = Functions::commit_sql($rekete, "");             //  echo 'Merci '.$rekete;
               
               if($result){
                   return principale::ajoutReketeSynchro($rekete);
               }  else {
                   return' 0';
               }
        }  else {
            return '2';
        }
    }    
    
    public function verifDoublonMod(){
        $condition = "designation = ? AND idlocalite = ? AND codeunique <> ? ";
        $param = array($this->designation, $this->idlocalite, $this->codeunique);
        $result = Functions::get_record_byCondition("bureauechange", $condition, $param);
        
        if($result == FALSE){
            
            return FALSE;
        }  else {
            return TRUE;
        }
        
     }
     public function modifBureauechange(){
         if(!$this->verifDoublonMod()){ 
            $rekete = "update bureauechange set designation ='" . $this->designation . "', idlocalite ='" . $this->idlocalite . "' "; 
            $rekete .="where codeunique ='" . $this->codeunique . "' ";
            $result = Functions::commit_sql($rekete, "");            //echo 'Merci '.$rekete;
            if($result){
                return principale::ajoutReketeSynchro($rekete);
            }  else {
                return  '0';
            }
         }  else {
             return '2';
         }
     }
     
     public static function donnee($result){
         
         $affich = array();
         if($result){
             $i = 0;
             while ($list = $result->fetch()){
                 $affich[$i]["id"] = $list['id'];
                 $affich[$i]["num"] = $i +1;
                 $affich[$i]["codeunique"] = $list['codeunique'];
                 $affich[$i]["idlocalite"] = $list['idlocalite'];
                 $affich[$i]["liblocalite"] = Localite::libuniquelocalite($list['idlocalite']);
                 $affich[$i]["designation"] = $list['designation'];
                 
                 $i++;
             }
         }
         
         return $affich;
     }
     
     public static function bureauechangeParCritere($critere = ""){
         $rekete = "select * from bureauechange" . $critere;
         $result = Functions::commit_sql($rekete, "");       //  echo ' Merci '.$rekete;
         $affich = bureauechange::donnee($result);
         return $affich;
         
     }
     
     public static function listBureauechangePourCombo(){
         
         $donnee = bureauechange::getAllBureauechangeInfo();
         $list = '';
         $i = 0;
         foreach ($donnee as $v){
             
             if($i > 0){
                 $list .= '-->';
                 }
                 $list .= $v['codeunique'] . '|' . $v['designation'];
                 $i++;
         }
         return $list;
      
    }
    
    public static function afficheTitre($conf){
        ?>
        
        <?php
        $titre = '';
        switch ($conf){
            case 'bureauechange';
                $titre = "liste des bureauechanges";
                break;
            
            case 'addbureauechange';
                $titre = "Ajout de bureauechange";
                break;
            
            case 'editbureauechange';
                $titre = "Modification de bureauechange";
                break;
                            
        }
        return $titre;
     
    }
    
    static function afficheContenu($conf, $retour){
        $titre = bureauechange::afficheTitre($conf);
        $critere = "";
        ?>
        <div class="page-header" id="entetePage">
            <h4><?php echo $titre; ?></h4>
                       
        </div>
        <?php 
        switch ($conf){
            case  'bureauechange':
                $donnee = bureauechange::bureauechangeParCritere($critere);
                ?>
                <div id="info" ></div>
                <div class="btn-toolbar">
                    <div class="btn-group">
                       <a href="#" onclick="JPrincipal.afficheContenu(0, 'addbureauechange', '', '<?php echo $retour; ?>');" id="addsecteur" class="btn btn-small btn-success"><i class="icon-plus-sign icon-white"></i> Nouveau</a>                
                    </div>
                    <div class="btn-group pull-right">
                        <a href="#" onclick="JVisualisation.imprimer()('<?php echo $conf; ?>');" id="printliste" class="btn btn-small"><i class="icon-print"></i>Imprimer</a>
                        <a href="#" onclick="JVisualisation.exportexcel('<?php echo $conf; ?>');" id="exportliste" class="btn btn-small"><i class="icon-download"></i> Exporter</a>
                    </div>
                         <img id="loading" style="margin-left: 10px; visibility: hidden; width: 30px; height: 30px" alt="loading" title="loading..." src="./images/loader.gif"/>
                </div>
                
                <div id="zoneListeSite" data-spy="scroll">
                <?php
                bureauechange::afficheliste($donnee);
                ?>
                </div>    
                <?php  
                break;
            case 'addbureauechange':
                $retour = "bureauechange";
                bureauechange::formAddEdit($retour, '');
                
                break;
            case 'editbureauechange':
                $retour = "bureauechange";
                $codeunique = '';
                if(isset($_SESSION['idenreg']))
                    $codeunique = $_SESSION['idenreg'];
                bureauechange::formAddEdit($retour, $codeunique);
                break;
                
        }

    }
    
    static function afficheListe($donnee){
        if(sizeof($donnee,1)== 0){
            ?>
            <div class="alert alert-warning">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Infos!</strong>
                Aucune information n'est disponible pour le moment
                
            </div>   
            <?php     
        }  else {
            ?>
              <table border="0" class=" display table table-bordered" width="100%">
                  <thead>
                      <tr class="menu_gauche"> 
                          <th><strong>N°</strong></th>
                          <th><strong>Localite</strong></th>
                          <th><strong>Designation</strong></th>
                          <th style="width: 110px"><strong>Action</strong></th>
                      </tr>
                  </thead>
                  
                  <tbody>                 
          
            <?php  
            $i = 0;
            foreach ($donnee as $v) :
                $i++;
                ?>
                      <tr>
                          <td><?php echo $v['num']?></td>
                          <td><?php echo $v['liblocalite']?></td>
                          <td><?php echo $v['designation']?></td>
                          <td>
                              <div class=" btn-group">
                                  <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                                      Action
                                      <span class="caret"></span>
                                  </a>
                                  <ul class="dropdown-menu">
                                      <li>
                                          <a href="#" class="btn btn-small" onclick="JPrincipal.afficheContenu('<?php echo $v['codeunique'];?>', 'editbureauechange', '', '');" title="Modifier"><i class="icon-edit"></i>Modifier</a>  
                                      </li>
                                      
                                  </ul>
                                  
                              </div>
                          </td>
                      </tr>
                <?php       
            endforeach;
            unset($donnee);
            ?>
                  </tbody>    
              </table>
              <input type="hidden" id="nbreparam" value="<?php echo $i; ?>" />  
            <?php
        }
        
    }
    
     static function formAddEdit($retour, $codeunique = '') {
//                  Functions::afficheBoiteMsg($codeunique);
          //formulaire d ajout ou modification des données
                $critere = " WHERE codeunique = '" . $codeunique . "'";
                $d = bureauechange::bureauechangeParCritere($critere); //
                $b = (sizeof($d, 1) > 0) ? 1 : 0;
                ?> 
        <div id="info"></div>
        <p>
            <a href="#" onclick="JPrincipal.afficheContenu(0, '<?php echo $retour; ?>', '<?php echo ''; ?>', '<?php echo $retour; ?>');" id="alltypeoperationfinanciere" class="btn btn-small"><i class="icon-arrow-left"></i> Retour</a>
        </p>
        <div id="zoneadd">

        </div>
        <div class="validateTips"><p class="alert alert-info"><b>Tous les champs (*) sont obligatoires</b></p></div>
        <form class="form-horizontal" method="post" name="formaddedit" id="formaddedit" action="" >                    
            <div class="well well-large">               

                <div class="control-group">
                    <label class="control-label" for="designation"><strong>Designation (*)</strong></label>
                    <div class="controls">
                        <input type="text" style="height:30px; width:400px;" onkeyup="JPrincipal.enMajuscule('designation', 1);" name="designation" id="designation" class="text ui-widget-content ui-corner-all" value="<?php echo ($b == 1) ? $d[0]['designation'] : ""; ?>" />
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="liblocalite"><strong>Localité (*)</strong></label>
                    <div class="controls">
                       <?php 
                       $rekete = "SELECT * FROM localite";
                       echo Functions::LoadCombo($rekete, 'codeunique', "libunique", 'idlocalite', "Selectionner la localité", '400', '', ($b == 1) ? $d[0]['idlocalite'] : ""); ?>
                    </div>
                </div>

                
                <div class="control-group">
                    <label class="control-label"></label>
                    <div class="controls">                        
                        <input type="button" onclick="JTraitement.valider('<?php echo $codeunique; ?>', 'bureauechange');" class="btn btn-small btn-success" value="Enregistrer"/>
                    </div>
                </div>   
            </div>                         
        </form>                        
        <?php
    }

    public static function valider($codeunique, $retour, $champ) {
        $e = new bureauechange($codeunique);
        $e->setDesignation(addslashes($champ[0]));
        $e->setIdlocalite(addslashes($champ[1]));
        
        
        $result = 0;
        if ($codeunique == "") {
            $result = $e->ajoutBureauechange();
        } else {
            $result = $e->modifBureauechange();
        }
        switch ($result) {
            case '0':
                ?>
                <script>
                            $("#info", window.parent.document).html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Info !</strong> La bureauechange n\'a pas été enregistrée : erreur de connexion. </div>').fadeIn(1000);
                </script>
                <?php
                break;

            case '1':
                ?>
                <script>
                    $("#info", window.parent.document).html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Info !</strong> Le bureau d\'échange a été enregistrée avec succès. </div>').fadeIn(1000);
                    JPrincipal.afficheContenu(0, '<?php echo $retour; ?>', '', '');
                </script>
                <?php
                break;

            case '2':
                ?>
                <script>
                    $("#info", window.parent.document).html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Info !</strong> Le bureau d\'échange que vous tentez d\'enregistrer existe déja. </div>').fadeIn(500);
                </script>
                <?php
                break;
        }
    }

    
}
?>
