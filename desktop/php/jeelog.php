<?php
if (!isConnect('admin')) {
  throw new Exception('{{401 - Accès non autorisé}}');
}

$plugin = plugin::byId('jeelog');
sendVarToJS('eqType', $plugin->getId());
$eqLogics = eqLogic::byType($plugin->getId());
?>

<div class="row row-overflow">
    <div class="col-lg-2 col-md-3 col-sm-4">
        <div class="bs-sidebar">
            <ul id="ul_eqLogic" class="nav nav-list bs-sidenav">
                <a class="btn btn-default eqLogicAction" style="width : 100%;margin-top : 5px;margin-bottom: 5px;" data-action="add"><i class="fa fa-plus-circle"></i> {{Ajouter un jeelog}}</a>
                <li class="filter" style="margin-bottom: 5px;"><input class="filter form-control input-sm" placeholder="{{Rechercher}}" style="width: 100%"/></li>
                <?php
foreach ($eqLogics as $eqLogic) {
  $opacity = ($eqLogic->getIsEnable()) ? '' : jeedom::getConfiguration('eqLogic:style:noactive');
  echo '<li class="cursor li_eqLogic" data-eqLogic_id="' . $eqLogic->getId() . '" style="' . $opacity .'"><a>' . $eqLogic->getHumanName(true) . '</a></li>';
}
        ?>
           </ul>
       </div>
   </div>

   <div class="col-lg-10 col-md-9 col-sm-8 eqLogicThumbnailDisplay" style="border-left: solid 1px #EEE; padding-left: 25px;">
    <legend>{{Mes jeelogs}}</legend>
  <legend><i class="fa fa-cog"></i>  {{Gestion}}</legend>
  <div class="eqLogicThumbnailContainer">
      <div class="cursor eqLogicAction" data-action="add" style="text-align: center; background-color : #ffffff; height : 120px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;" >
        <i class="fa fa-plus-circle" style="font-size : 6em;color:#94ca02;"></i>
        <br>
        <span style="font-size : 1.1em;position:relative; top : 23px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;color:#94ca02">{{Ajouter}}</span>
    </div>
      <div class="cursor eqLogicAction" data-action="gotoPluginConf" style="text-align: center; background-color : #ffffff; height : 120px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;">
      <i class="fa fa-wrench" style="font-size : 6em;color:#767676;"></i>
    <br>
    <span style="font-size : 1.1em;position:relative; top : 15px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;color:#767676">{{Configuration}}</span>
  </div>
  </div>
  <legend><i class="fa fa-table"></i> {{Mes jeelogs}}</legend>
<div class="eqLogicThumbnailContainer">
    <?php
foreach ($eqLogics as $eqLogic) {
  $opacity = ($eqLogic->getIsEnable()) ? '' : jeedom::getConfiguration('eqLogic:style:noactive');
  echo '<div class="eqLogicDisplayCard cursor" data-eqLogic_id="' . $eqLogic->getId() . '" style="text-align: center; background-color : #ffffff; height : 200px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;' . $opacity . '" >';
  echo '<img src="' . $plugin->getPathImgIcon() . '" height="105" width="95" />';
  echo "<br>";
  echo '<span style="font-size : 1.1em;position:relative; top : 15px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;">' . $eqLogic->getHumanName(true, true) . '</span>';
  echo '</div>';
}
?>
</div>
</div>

<div class="col-lg-10 col-md-9 col-sm-8 eqLogic" style="border-left: solid 1px #EEE; padding-left: 25px;display: none;">
  <a class="btn btn-success eqLogicAction pull-right" data-action="save"><i class="fa fa-check-circle"></i> {{Sauvegarder}}</a>
  <a class="btn btn-danger eqLogicAction pull-right" data-action="remove"><i class="fa fa-minus-circle"></i> {{Supprimer}}</a>
  <a class="btn btn-default eqLogicAction pull-right" data-action="configure"><i class="fa fa-cogs"></i> {{Configuration avancée}}</a>
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation"><a href="#" class="eqLogicAction" aria-controls="home" role="tab" data-toggle="tab" data-action="returnToThumbnailDisplay"><i class="fa fa-arrow-circle-left"></i></a></li>
    <li role="presentation" class="active"><a href="#eqlogictab" aria-controls="home" role="tab" data-toggle="tab"><i class="fa fa-tachometer"></i> {{Equipement}}</a></li>
    <li role="presentation"><a href="#logtab" aria-controls="profile" role="tab" data-toggle="tab"><i class="fa fa-list-alt"></i> {{Logs}}</a></li>
  </ul>
  <div class="tab-content" style="height:calc(100% - 50px);overflow:auto;overflow-x: hidden;">

  <div role="tabpanel" class="tab-pane active" id="eqlogictab">
    <br/>
    <form class="form-horizontal">
      <fieldset>
          <div class="form-group">
              <label class="col-sm-3 control-label">{{Nom de l'équipement jeelog}}</label>
              <div class="col-sm-3">
                  <input type="text" class="eqLogicAttr form-control" data-l1key="id" style="display : none;" />
                  <input type="text" class="eqLogicAttr form-control" data-l1key="name" placeholder="{{Nom de l'équipement jeelog}}"/>
              </div>
          </div>
          <div class="form-group">
              <label class="col-sm-3 control-label" >{{Objet parent}}</label>
              <div class="col-sm-3">
                  <select id="sel_object" class="eqLogicAttr form-control" data-l1key="object_id">
                      <option value="">{{Aucun}}</option>
                      <?php
                        foreach (object::all() as $object) {
                         echo '<option value="' . $object->getId() . '">' . $object->getName() . '</option>';
                        }
                      ?>
                 </select>
             </div>
         </div>
         <div class="form-group">
              <label class="col-sm-3 control-label">{{Catégorie}}</label>
              <div class="col-sm-9">
               <?php
                  foreach (jeedom::getConfiguration('eqLogic:category') as $key => $value) {
                  echo '<label class="checkbox-inline">';
                  echo '<input type="checkbox" class="eqLogicAttr" data-l1key="category" data-l2key="' . $key . '" />' . $value['name'];
                  echo '</label>';
                  }
                ?>
             </div>
         </div>

        <div class="form-group">
          <label class="col-sm-3 control-label"></label>
          <div class="col-sm-9">
            <label class="checkbox-inline"><input type="checkbox" class="eqLogicAttr" data-l1key="isEnable" checked/>{{Activer}}</label>
            <label class="checkbox-inline"><input type="checkbox" class="eqLogicAttr" data-l1key="isVisible" checked/>{{Visible}}</label>
          </div>
        </div>

        <br/><br/>
        <div class="form-group expertModeVisible">
          <label class="col-sm-2 control-label">{{Auto-actualisation (cron)}}</label>
          <div class="col-sm-2">
            <input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="autorefresh" placeholder="{{Auto-actualisation (cron)}}"/>
          </div>
          <div class="col-sm-1">
            <i class="fa fa-question-circle cursor floatright" id="bt_cronGenerator"></i>
          </div>
        </div>

        <div class="form-group expertModeVisible">
          <label class="col-sm-2 control-label">{{Afficher (heures)}}</label>
          <div class="col-sm-2">
           <input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="loglasttime" placeholder="8"/>
          </div>
        </div>
        
        <div class="form-group expertModeVisible">
          <label class="col-sm-2 control-label">{{Dashboard width/height}}</label>
          <div class="col-sm-1">
           <input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="dashboardWidth" placeholder="360"/>
          </div>
          <div class="col-sm-1">
           <input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="dashboardHeight" placeholder="144"/>
          </div>
        </div>
        
        <div class="form-group expertModeVisible">
          <label class="col-sm-2 control-label">{{Vue width/height}}</label>
          <div class="col-sm-1">
           <input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="viewWidth" placeholder="450"/>
          </div>
          <div class="col-sm-1">
           <input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="viewHeight" placeholder="560"/>
          </div>
        </div>

      </fieldset>
    </form>
  </div>



    <div role="tabpanel" class="tab-pane" id="logtab">
      <a class="btn btn-success pull-right" id="bt_addScenario" style="margin-top: 5px;"><i class="fa fa-plus-circle"></i> {{Ajouter Scenario}}</a>
      <a class="btn btn-success pull-right" id="bt_addCmd" style="margin-top: 5px;"><i class="fa fa-plus-circle"></i> {{Ajouter Commande}}</a><br/><br/>

      <div id="div_logs"></div>
    </div>
  </div>
</div>

<?php include_file('desktop', 'jeelog', 'js', 'jeelog');?>
<?php include_file('core', 'plugin.template', 'js');?>
