<?php echo form_open($this->uri->uri_string(),'ng-model="form_asig"');?>
    <div class="alert alert-info"><?=lang('asignacion:inst_'.$this->method)?></div>

<div class="form-group">
    <label>Centro/Plantel</label>
    <?php //echo form_dropdown('id_centro',array(''=>'Ninguno')+$centros,false,'class="form-control" ng-model="id_centro"')?>
    <ul class="modal_select">
    <?php if($disciplinas):?>
        <li><a confirm-action href="<? //=base_url('admin/ceneval/asignacion/add///0')?>">Ninguno</a>
    <?php endif;?>
    <?php foreach($disciplinas as $disciplina):?>
        <li><a confirm-action href="<?=base_url('admin/medallero/create/'.$id_evento.'/'.$disciplina->id)?>"><?=$disciplina->nombre?></a></li>
    <?php endforeach;?>
    </ul>
</div>
<?php echo form_close();?>