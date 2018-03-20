<section>
    <div class="lead text-success"><?=sprintf(lang('medallero:on_'.$this->method),$disciplina->nombre)?></div>
    <?php echo form_open($this->uri->uri_string(),'method="post"');?>
                                    <div class="form-group">
                                        <label><span class="text-danger">*</span>Centro/Plantel</label>
                                        <?=form_dropdown('id_centro',array(''=>' [ Elegir ] ')+$centros,$medallero->id_centro,'class="form-control"');?>
                                    </div>
                                    <div class="form-group">
                                        <label>Participante</label>
                                        <?=form_input('participante',$medallero->participante,'class="form-control"');?>
                                    </div>
                                    <div class="form-group">
                                        <label><span class="text-danger">*</span>Posición</label>
                                        <?=form_input('posicion',$medallero->posicion,'class="form-control"');?>
                                    </div>
                                    
        <div class="divider"></div>
                <p>Los campos marcacos con (*) son obligatorios</p>
        <div class="buttons float-right padding-top">
     			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )) ?>
  		</div>
     <?php echo  form_close();?>
</section>