<section ng-controller="InputCtrl">
    <div class="lead text-success"><?=lang('disciplinas:'.$this->method)?></div>
    <?php echo form_open($this->uri->uri_string(),'method="post"');?>
        <div class="row">
            <div class="col-md-6">
                 <div class="form-group">
                                        <label><span class="text-danger">*</span>Tipo</label>
                                        <?=form_dropdown('tipo',array(''=>' [ Elegir ] ')+$tipos,$disciplina->tipo,'class="form-control"');?>
                 </div>
                 
                 <div class="form-group">
                    <label><span class="text-danger">*</span>Mínimo participantes</label>
                    <?=form_input('min',$disciplina->min,'class="form-control"')?>
                 </div>
            </div>
            
            <div class="col-md-6">
                 <div class="form-group">
                                        <label><span class="text-danger">*</span>Rama</label>
                                        <?=form_dropdown('rama',array('0'=>' Indistinto ','2'=>'Femenil','1'=>'Varonil','3'=>'Ambos'),$disciplina->rama,'class="form-control"');?>
                 </div>
                 <div class="form-group">
                    <label><span class="text-danger">*</span>Máximo participantes</label>
                     <?=form_input('max',$disciplina->max,'class="form-control"')?>
                 </div>
            </div>
        </div>
                                   
                                   
                                    <div class="form-group">
                                        <label><span class="text-danger">*</span>Nombre</label>
                                        <?=form_input('nombre',$disciplina->nombre,'class="form-control"');?>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Descripcion</label>
                                        <?=form_textarea('descripcion',$disciplina->descripcion,'class="form-control"');?>
                                    </div>
                                    <div class="form-group">
                                        <label>Video YOUTUBE</label>
                                        <?=form_input('video',$disciplina->video,'class="form-control"');?>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Galería</label>
                                        <?=form_dropdown('galeria',array(''=>'Ninguno')+$folders,$disciplina->galeria,'class="form-control"');?>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                             <div class="form-group">
                                                <label>Fecha</label>
                                       	        <?=form_input('fecha',$disciplina->fecha,'class="form-control"')?>
                                             </div>
                                             
                                              <div class="form-group">
                                                <label>Activo</label>
                                       	        <?=form_dropdown('activo',array('0'=>'No','1'=>'Si'),$disciplina->activo,'class="form-control"')?>
                                             </div>
                                        </div>
                                         <div class="col-lg-6">
                                            
                                            <div class="form-group">
                                                <label>Horario</label>
                                                <?=form_input('horario',$disciplina->horario,'class="form-control"');?>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                    
        <div class="divider"></div>
                <p>Los campos marcacos con (*) son obligatorios</p>
        <div class="buttons float-right padding-top">
     			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )) ?>
  		</div>
     <?php echo  form_close();?>
</section>