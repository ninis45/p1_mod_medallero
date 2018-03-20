<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Roles controller for the groups module
 *
 * @author		Phil Sturgeon
 * @author		PyroCMS Dev Team
 * @package	 PyroCMS\Core\Modules\Groups\Controllers
 *
 */
class Admin extends Admin_Controller
{

	/**
	 * Constructor method
	 */
	protected $section = 'medallero';
	public function __construct()
	{
			parent::__construct();
            $this->template->enable_parser(true);
            $this->lang->load('medallero');
            $this->load->model(array(
                'disciplina_m',
                'eventos/evento_m',
                'medallero_m',
                'centros/centro_m'
            ));
            
            $this->validation_rules = array(
 		             array(
						'field' => 'id_centro',
						'label' => 'Centro/Plantel',
						'rules' => 'trim|required'
						),
					array(
						'field' => 'participante',
						'label' => 'Participante',
						'rules' => 'trim'
						),
     	              array(
						'field' => 'posicion',
						'label' => 'Posición',
						'rules' => 'trim|numeric|required'
						),
            );
            
             $tipos = array('cultural'=>'Cultural','civico'=>'Cívico','deportivo'=>'Deportivo','conocimiento'=>'Conocimiento','academico'=>'Académico');
            $this->template->set('tipos',$tipos);
    }
    
    function index()
    {
        $eventos = $this->db->get('eventos')->result();
        $this->template
                ->set('eventos',$eventos)
                ->build('admin/init');
    }
    function load($id=0)
    {
        $evento = $this->db->where('id',$id)->get('eventos')->row() OR redirect('admin/medallero');
        $data   = array();
        
        $base_where = array('id_evento'=>$id);
        $base_like  = array();
        
        $f_tipo     = $this->input->get('f_tipo');
        $f_keywords = $this->input->get('f_keywords');
        
        
        if($f_tipo)
        {
            $base_where['tipo'] = $f_tipo;
        }
        
        if($f_keywords)
        {
            $base_like['nombre'] = $f_keywords;
        }
        
        
        $disciplinas = $this->disciplina_m->like($base_like)
                    ->get_many_by($base_where);
        
        foreach($disciplinas as &$disciplina)
        {
            $disciplina->medallero = $this->medallero_m->select('*,medallero.id AS id')
                                            ->order_by('posicion')
                                            ->join('centros','centros.id=medallero.id_centro')
                                            ->get_many_by(array('id_evento'=>$id,'id_disciplina'=>$disciplina->id));                                           
            $disciplina->participantes = $this->db->select('count(*),centros.nombre AS nombre_centro')
                                ->where(array(
                                   'id_disciplina' => $disciplina->id,
                                   'id_evento'     => $id
                                ))
                                ->join('centros','centros.id=registros.id_centro')
                                ->group_by('centros.nombre')
                                ->get('registros')
                                
                                ->result();
            
        }
        //print_r($disciplinas);
        $this->template->append_js('module::medallero.controller.js')
                 ->set('disciplinas',$disciplinas)   
                ->set('evento',$evento)
                ->set('id',$evento->id)
                ->build('admin/index');
    }
    function create($id_evento=0,$id_disciplina=0)
    {
        $medallero = new StdClass();
        
        
        
        $evento = $this->evento_m->get($id_evento) or redirect('admin/medallero');
        
        
        $this->form_validation->set_rules($this->validation_rules);        
        
        
		if($this->form_validation->run())        
        {
			unset($_POST['btnAction']);
            
            if($this->medallero_m->add($id_evento,$id_disciplina,$this->input->post()))
            {
				
				$this->session->set_flashdata('success',sprintf(lang('medallero:save_success'),$this->input->post('participante')));
				
			}else{
				$this->session->set_flashdata('error',lang('global:save_error'));
				
			}
			redirect('admin/medallero/create/'.$id_evento.'/'.$id_disciplina);
        }
        
        if($this->input->is_ajax_request())
        {
            $disciplinas = $this->disciplina_m->get_many_by(array('id_evento'=>$id_evento));
            $this->template->set_layout(false);
        }
        else
        {
            $disciplina = $this->disciplina_m->get($id_disciplina);
            foreach ($this->validation_rules as $rule)
    		{
    			$medallero->{$rule['field']} = set_value($rule['field']);
    		}
            
            $ids_centros = $this->db->where('id_evento',$id_evento)
                                ->where('id_disciplina',$id_disciplina)
                                ->get('registros')->result();
                                
            if(!$ids_centros)
            {
                redirect('admin/medallero/'.$id_evento);
            }
            
            $centros = $this->centro_m->where_in('id',array_for_select($ids_centros,'id_centro','id_centro'))
                        ->dropdown('id','nombre');
        }
        
         
       $this->input->is_ajax_request()
       ? $this->template                    
                ->set('id_evento',$id_evento)
                ->set('disciplinas',$disciplinas)
                ->build('admin/disciplinas/list')
       :$this->template->set('id',$id_evento)
            ->set('medallero',$medallero)
            ->set('centros',$centros)
            ->set('disciplina',$disciplina)
            ->build('admin/form');
    }
    function delete($id_evento=0,$id=0)
    {
        if($id)
        {
            $base_where['id'] = $id;
        }
        
        $medallero = $this->medallero_m->get($id);
        
        if($medallero)
        {
            $this->db->where($base_where)->delete('medallero');
            
            $items = $this->medallero_m->order_by('posicion')->get_many_by(array(
                     
                        'id_evento' => $id_evento,
                        'id_disciplina' => $medallero->id_disciplina
                     ));
             time(100);
             foreach($items as $index=>$item)
             {
                 $this->db->where('id',$item->id)->set(array('posicion'=>$index+1))->update('medallero');
             }
            
        }
        
        
        
        redirect('admin/medallero/'.$id_evento);
    }
    function edit($id)
    {
        $medallero = $this->medallero_m->get($id);
        
       $this->form_validation->set_rules($this->validation_rules);        
        
        
		if($this->form_validation->run())        
        {
			unset($_POST['btnAction']);
            
            if($this->medallero_m->edit($id,$this->input->post()))
            {
				
				$this->session->set_flashdata('success',sprintf(lang('medallero:save_success'),$this->input->post('participante')));
				
			}else{
				$this->session->set_flashdata('error',lang('global:save_error'));
				
			}
			redirect('admin/medallero/'.$medallero->id_evento);
        }
        $disciplina = $this->disciplina_m->get($medallero->id_disciplina);
        $centros = $this->centro_m->dropdown('id','nombre');
        
        $this->template->set('centros',$centros)
                    ->set('medallero',$medallero)
                    ->set('disciplina',$disciplina)
                    ->set('id',$medallero->id_evento)
                ->build('admin/form'); 
    }
}
?>