<section>
     <?php echo form_open('admin/medallero/disciplinas/'.$id, 'class="form-inline" method="get" ') ?>
    		
    			
                <div class="form-group col-md-5">
    				<label for="f_concepto">Tipo de evento </label>
                    
                    <?=form_dropdown('f_tipo',array(''=>' [ Todos ] ')+$tipos,false,'class="form-control"')?>
    			</div>
    			<div class="form-group col-md-5">
    				<label for="f_keywords"><?php echo lang('global:keywords') ?></label>
    				<?php echo form_input('f_keywords', '', 'style="width: 60%;" class="form-control" placeholder="Nombre de la disciplina"') ?>
    			</div>
    
    			<button class="md-raised btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
    			
    			
    		
    	<?php echo form_close() ?>
     <hr />
     <?php echo form_open('admin/medallero/disciplinas/action', 'class="form-inline" method="post" ') ?>
     <p class="text-right text-muted">Total registros: <?=count($disciplinas)?> </p>
     <table   class="table" summary="catalogos"  width="100%" ng-controller="TableCtrl">
             <thead>
                 <tr>
                   <th width="3%">
                   		<label>
                        <?php echo  form_checkbox(array(
                                    'value'=>'1',
                                    'ng-model'=>'checked_all',
                                    'class'=>'check-all',
                                    
                                    ));?>
                                 
                        </label>
                   </th>
                   <th width="">Disciplina</th>
                   <th width="">Tipo</th>
                   <th width="">Rama</th>
                   <th>Activo</th>
                   <th width="14%">Acciones</th>
                </tr>
             </thead>
             <tbody> 
              <?php foreach($disciplinas as $disciplina){?>      	
              <tr class="row-table<?=$disciplina->activo==0?' danger':''?>" >
                  <td align="center" class="center">
                  	 
                      <?php echo  form_checkbox(array(
                                  
                                  'name'=>'action_to[]',
                                  'value'=>$disciplina->id,
                                  'ng-checked' =>'checked_all'
                                  
                            ));
                 
                      ?>	
                      	 
                     	
                   </td>
                   <td><?=$disciplina->nombre?></td>
                   <td><?=$tipos[$disciplina->tipo]?></td>
                   <td><?=$disciplina->rama?($disciplina->rama==1?'Varonil':'Femenil'):'Indistinto'?></td>                   
                   <td><?=$disciplina->activo=='1'?'Si':'No'?></td>
                   <td>
                        <?php echo anchor('admin/medallero/disciplinas/edit/'.$disciplina->id, lang('buttons:edit'), 'class="button edit"') ?> |
                        
                        
                        <?php echo anchor('admin/medallero/disciplinas/delete/'.$disciplina->id_evento.'/'.$disciplina->id, lang('buttons:delete'), 'confirm-action class="button confirm"') ?>
                   
                   </td>
              </tr>
              <?php }?>
             </tbody>
     </table>
     <div>
        <?php $this->load->view('admin/partials/buttons', array('buttons' => array('deactivate'))) ?>
        <input type="hidden" value="<?=$this->uri->uri_string()?>" name="url_return" />
     </div>
     <?php echo form_close() ?>
</section>