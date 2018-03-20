<section ng-controller="IndexCtrl">
    <div class="lead text-success"><?=$evento->titulo?></div>
    
     <?php echo form_open('admin/medallero/'.$id, 'class="form-inline" method="get" ') ?>
    		
    			
                <div class="form-group col-md-4">
    				<label for="f_concepto">Tipo de evento </label>
                    
                    <?=form_dropdown('f_tipo',array(''=>' [ Todos ] ')+$tipos,false,'class="form-control"')?>
    			</div>
    			<div class="form-group col-md-5">
    				<label for="f_keywords"><?php echo lang('global:keywords') ?></label>
    				<?php echo form_input('f_keywords', '', 'style="width: 60%;" class="form-control" placeholder="Nombre de la disciplina"') ?>
    			</div>
    
    			<button class="md-raised btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                <?php if($_GET):?>
                <a href="<?=base_url('admin/medallero/'.$id)?>" class="md-raised btn btn-success"><i class="fa fa-refresh"></i> Mostrar todos</a>
    			<?php endif;?>
    			
    		
    	<?php echo form_close() ?>
     <hr />
    
    <uib-accordion close-others="oneAtATime" class="ui-accordion">
        <?php foreach($disciplinas as $disciplina):?>
                                <uib-accordion-group heading="<?=$disciplina->nombre?> (<?=$disciplina->rama==1?'Varonil':($disciplina->rama==2?'Femenil':'Indistinto')?>) " >
                                    <div class="block">
                                        <a href="<?=base_url('admin/medallero/create/'.$disciplina->id_evento.'/'.$disciplina->id)?>"  class="btn btn-success btn-mini pull-right">Crear fase</a>
                                    </div>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>PARTICIPANTE</th>
                                                <th class="text-center" width="30%">POSICIÓN</th>
                                                <th width="10%"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach($disciplina->medallero as $medallero):?>
                                            <tr>
                                                <td>
                                                    <strong><?=$medallero->nombre?></strong><br />
                                                    <span class="help-inline"><?=$medallero->participante?></span>
                                                </td>
                                                <td class="text-center"><?=$medallero->posicion?></td>
                                                <td>
                                                    <a confirm-action href="<?=base_url('admin/medallero/delete/'.$id.'/'.$medallero->id)?>" ui-wave class="btn-icon  btn-icon-sm btn-danger"><i class="fa fa-trash"></i></a>
                                                    <a  href="<?=base_url('admin/medallero/edit/'.$medallero->id)?>" ui-wave class="btn-icon  btn-icon-sm btn-success"><i class="fa fa-pencil"></i></a>
                                                        
                                                </td>
                                            </tr>
                                        <?php endforeach;?>
                                        </tbody>
                                    </table>
                                    
                                </uib-accordion-group>
        <?php endforeach;?>
    </uib-accordion>
</section>
 <script type="text/ng-template" id="items_renderer.html">
                <div class="angular-ui-tree-handle">
                    <span>{{item.children}}</span>
                </div>
 </script>
 <script type="text/ng-template" id="items_renderer.html">
                <div class="angular-ui-tree-handle">
                    <span data-ng-show="item.children.length > 0"><a class="angular-ui-tree-icon" data-nodrag ng-click="toggle()">
                        <span class="angular-ui-tree-icon-collapse" ng-class="{'collapsed': collapsed, 'uncollapsed': !collapsed}"></span>
                    </a></span>
                    {{item.title}}
                    <a confirm-action href="<?=base_url('admin/navigation/delete')?>/{{ item.id }}" ng-click="form_action()" class="pull-right angular-ui-tree-icon angular-ui-tree-icon-action" data-nodrag ng-click="newSubItem(this)"><span class="fa fa-trash"></span></a>
                    <a href="<?=base_url('admin/navigation#/edit')?>/{{ item.id }}" ng-click="form_action()" class="pull-right angular-ui-tree-icon angular-ui-tree-icon-action" data-nodrag ng-click="newSubItem(this)"><span class="fa fa-edit"></span></a>
                </div>
                <ol  ui-tree-nodes="options" ng-model="item.children" ng-class="{hidden: collapsed}">
                    <li  ng-repeat="item in item.children" ui-tree-node ng-include="'items_renderer.html'">
                    </li>
                </ol>
 </script>