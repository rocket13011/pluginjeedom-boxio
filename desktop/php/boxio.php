<?php
if (!isConnect('admin')) {
    throw new Exception('Error 401 Unauthorized');
}
sendVarToJS('eqType', 'boxio');
$eqLogics = eqLogic::byType('boxio');
?>

<script type="text/javascript">

</script>

<div class="row row-overflow">
    <div class="col-lg-2 col-md-3 col-sm-4">
        <div class="bs-sidebar">
            <ul id="ul_eqLogic" class="nav nav-list bs-sidenav">
				<li class="filter" style="margin-bottom: 5px;"><input class="filter form-control input-sm" placeholder="Rechercher" style="width: 100%"/></li>
                <?php
                foreach ($eqLogics as $eqLogic) {
                    $opacity = ($eqLogic->getIsEnable()) ? '' : jeedom::getConfiguration('eqLogic:style:noactive');
					echo '<li class="cursor li_eqLogic" data-eqLogic_id="' . $eqLogic->getId() . '" style="' . $opacity . '"><a>' . $eqLogic->getHumanName(true) . '</a></li>';
                }
                ?>
			</ul>
		</div>
	</div>
<div class="col-lg-10 col-md-9 col-sm-8 eqLogicThumbnailDisplay" style="border-left: solid 1px #EEE; padding-left: 25px;">
	<legend><i class="fa fa-cog"></i>  {{Gestion}}</legend>
	<div class="eqLogicThumbnailContainer">
		<div class="cursor eqLogicAction" data-action="add" style="background-color : #ffffff; height : 140px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;" ><center>
			<i class="fa fa-plus-circle" style="font-size : 5em;color:#94ca02;"></i></center>
			<span style="font-size : 1.1em;position:relative; top : 15px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;color:#94ca02"><center>Ajouter</center></span>
		</div>
		<div class="cursor eqLogicAction" data-action="gotoPluginConf" style="background-color : #ffffff; height : 140px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;"><center>
			<i class="fa fa-wrench" style="font-size : 6em;color:#767676;"></i></center>
			<span style="font-size : 1.1em;position:relative; top : 23px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;color:#767676"><center>{{Configuration}}</center></span>
		</div>
		<div class="cursor expertModeVisible" id="bt_syncEqLogic" style="background-color : #ffffff; height : 140px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;" ><center>
			<i class="fa fa-refresh" style="font-size : 6em;color:#767676;"></i></center>
			<span style="font-size : 1.1em;position:relative; top : 23px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;color:#767676"><center>{{Synchroniser}}</center></span>
		</div>	
        <legend><i class="fa fa-table"></i>{{Mes Equipements Boxio}}</legend>
		
		<div class="eqLogicThumbnailContainer">
        <div class="cursor eqLogicAction" data-action="add" style="background-color : #ffffff; height : 200px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;" >
         <center>
            <i class="fa fa-plus-circle" style="font-size : 7em;color:#94ca02;"></i>
        </center>
        <span style="font-size : 1.1em;position:relative; top : 23px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;color:#94ca02"><center>Ajouter</center></span>
    </div>
        <?php
			foreach ($eqLogics as $eqLogic) {
				$device_id = substr($eqLogic->getConfiguration('device'), 0, strpos($eqLogic->getConfiguration('device'), ':'));
				$opacity = ($eqLogic->getIsEnable()) ? '' : jeedom::getConfiguration('eqLogic:style:noactive');
				echo '<div class="eqLogicDisplayCard cursor" data-eqLogic_id="' . $eqLogic->getId() . '" style="background-color : #ffffff; height : 200px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;' . $opacity . '" >';
				echo "<center>";
				if (file_exists(dirname(__FILE__) . '/../../core/config/devices/' . $device_id . '.jpg')) {
					echo '<img class="lazy" src="plugins/boxio/core/config/devices/' . $device_id . '.jpg" height="105" width="95" />';
				} else {
					echo '<img class="lazy" src="plugins/boxio/doc/images/boxio_icon.png" height="105" width="95" />';
				}
				echo "</center>";
				echo '<span style="font-size : 1.1em;position:relative; top : 15px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;"><center>' . $eqLogic->getHumanName(true, true) . '</center></span>';
				echo '</div>';
			}
			?>
		</div>
		</div>

    <div class="col-lg-10 col-md-9 col-sm-8 eqLogic" style="border-left: solid 1px #EEE; padding-left: 25px;display: none;">
        <div class="row">
            <div class="col-sm-6">
                <form class="form-horizontal">
                    <fieldset>
                        <legend><i class="fa fa-arrow-circle-left eqLogicAction cursor" data-action="returnToThumbnailDisplay"></i> {{Général}}
                            <i class='fa fa-cogs eqLogicAction pull-right cursor expertModeVisible' data-action='configure'></i>
                            <a class="btn btn-xs btn-default pull-right eqLogicAction" data-action="copy"><i class="fa fa-files-o"></i> {{Dupliquer}}</a>
                        </legend>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Nom de l'équipement Boxio</label>
                            <div class="col-sm-4">
                                <input type="text" class="eqLogicAttr form-control" data-l1key="id" style="display : none;" />
								<input type="text" class="eqLogicAttr form-control" data-l1key="name" placeholder="Nom de l'équipement Boxio"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">ID</label>
                            <div class="col-sm-4">
                                <input type="text" id="boxioid" class="eqLogicAttr form-control" data-l1key="logicalId" placeholder="Logical ID"/>
                            </div>
                        </div>
						<div class="form-group">
                            <label class="col-sm-3 control-label"></label>
                            <div class="col-sm-8">
								<input type="checkbox" class="eqLogicAttr bootstrapSwitch" data-label-text="{{Activer}}" data-l1key="isEnable" checked/>
								<input type="checkbox" class="eqLogicAttr bootstrapSwitch" data-label-text="{{Visible}}" data-l1key="isVisible" checked/> 
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" >Objet parent</label>
                            <div class="col-sm-4">
                                <select class="eqLogicAttr form-control" data-l1key="object_id">
                                    <option value="">Aucun</option>
                                    <?php
                                    foreach (object::all() as $object) {
                                        echo '<option value="' . $object->getId() . '">' . $object->getName() . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Catégorie</label>
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
                            <label class="col-sm-3 control-label">{{Media}}</label>
                            <div class="col-sm-9">
								<select class="eqLogicAttr" data-l1key="configuration" data-l2key="media">
									<option value="CPL" />CPL</option>
									<option value="RF" />RF</option>
									<option value="IR" />IR</option>
								</select> 
							</div>
                        </div>
						
                        <div class="form-group">
                            <label class="col-sm-3 control-label">{{Commentaire}}</label>
                            <div class="col-sm-8">
                                <textarea class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="commentaire" ></textarea>
                            </div>
                        </div>
                    </fieldset> 
                </form>
            </div>
            <div class="col-sm-6">
                <form class="form-horizontal">
                    <fieldset>
                        <legend>Informations</legend>
                         <div id="div_instruction"></div>
						 <div class="form-group expertModeVisible">
                            <label class="col-sm-3 control-label">{{Création}}</label>
                            <div class="col-sm-3">
                                <span class="eqLogicAttr label label-default tooltips" data-l1key="configuration" data-l2key="createtime" title="{{Date de création de l'équipement}}" style="font-size : 1em;"></span>
                            </div>
							<label class="col-sm-3 control-label">{{Communication}}</label>
							<div class="col-sm-3">
								<span class="eqLogicAttr label label-default tooltips" data-l1key="status" data-l2key="lastCommunication" title="{{Date de dernière communication}}" style="font-size : 1em;"></span>
							</div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Equipement</label>
                            <div class="col-sm-6">
                                <select class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="device">
                                    <option value="">Aucun</option>
                                    <?php
                                    foreach (boxio::devicesParameters() as $packettype => $info) {
                                        foreach ($info['subtype'] as $subtype => $subInfo) {
                                            echo '<option value="' . $packettype . '::' . $subtype . '">' . $packettype . ' - ' . $info['name'] . ' - ' . 	$subInfo['name'] . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <a class="btn btn-warning" id="bt_shareOnMarket"><i class="fa fa-cloud-upload"></i> {{Partager}}</a>
                            </div>
                        </div>
						<div class="form-group">
                            <label class="col-sm-3 control-label">Version Utilisée</label>
                            <div class="col-sm-3">
								<span class="eqLogicAttr label label-default tooltips" data-l1key="configuration" data-l2key="version" style="font-size : 1em;"></span>
                            </div>
                        </div>
                        <div class="form-group expertModeVisible">
                            <label class="col-sm-3 control-label">{{Envoyer une configuration}}</label>
                            <div class="col-sm-5">
                                <input id="bt_uploadConfboxio" type="file" name="file" data-url="plugins/boxio/core/ajax/boxio.ajax.php?action=uploadConfboxio">
                            </div>
                        </div>
                        <div class="form-group expertModeVisible">
                            <label class="col-sm-3 control-label">{{Délai maximum autorisé entre 2 messages (min)}}</label>
                            <div class="col-sm-4">
                                <input class="eqLogicAttr form-control" data-l1key="timeout" />
                            </div>
                        </div>
						<?php
						/*<div class="form-group">
                            <label class="col-sm-3 control-label">{{Fonctionnement en mode Scénario}}</label>
                            <div class="col-sm-8">
								<input type="checkbox" class="eqLogicAttr bootstrapSwitch" data-label-text="{{Activer}}" data-l1key="ModeScenario" checked/>
                            </div>
                        </div>*/?>
                    </fieldset> 
                </form>
            </div>
        </div>

        <legend>Commandes</legend>


        <a class="btn btn-success btn-sm cmdAction" data-action="add"><i class="fa fa-plus-circle"></i> Ajouter une commande</a><br/><br/>
        <table id="table_cmd" class="table table-bordered table-condensed">
            <thead>
                <tr>
                    <th style="width: 300px;">Nom</th>
                    <th style="width: 130px;" class="expertModeVisible">Type</th>
					<th style="width: 70px;" class="expertModeVisible">Unit</th>
					<th style="width: 130px;" class="expertModeVisible">Communication</th>
                    <th class="expertModeVisible">Logical ID (info) ou Commande brute (action)</th>
                    <th>Paramètres</th>
                    <th style="width: 100px;">Options</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>

		<legend>Equipements pilotés</legend>


        <a class="btn btn-success pull-left" id="bt_updateMemory"><i class="fa fa-refresh"></i> Mettre à jour</a><br/><br/>
        <table id="table_mem" class="table table-bordered table-condensed">
            <thead>
                <div class="form-group">
					<tr>
						<th style="width: 200px;">Emplacement</th>
						<th style="width: 200px;">ID</th>
						<th style="width: 200px;">UNIT</th>
						<th style="width: 200px;">ID Listen</th>
						<th style="width: 200px;">UNIT Listen</th>
						<th style="width: 200px;">Fonction</th>
						<th style="width: 200px;">Media</th>
					</tr>
				</div>				
            </thead>
            <tbody>

            </tbody>
        </table>
		
        <form class="form-horizontal">
            <fieldset>
                <div class="form-actions">
                    <a class="btn btn-danger eqLogicAction" data-action="remove"><i class="fa fa-minus-circle"></i> Supprimer</a>
                    <a class="btn btn-success eqLogicAction" data-action="save"><i class="fa fa-check-circle"></i> Sauvegarder</a>
                </div>
            </fieldset>
        </form>

    </div>
</div>

<?php include_file('desktop', 'boxio', 'js', 'boxio'); ?>
<?php include_file('core', 'plugin.template', 'js'); ?>
