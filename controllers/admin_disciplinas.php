<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Admin Blog Fields
 *
 * Manage custom blogs fields for
 * your blog.
 *
 * @author 		PyroCMS Dev Team
 * @package 	PyroCMS\Core\Modules\Users\Controllers
 */
class Admin_disciplinas extends Admin_Controller {

	protected $section = 'disciplinas';

	// --------------------------------------------------------------------------

	public function __construct()
	{
		parent::__construct();
        $this->template->enable_parser(true);
        $this->lang->load('medallero');
        $this->load->model(array(
            'disciplina_m',
            'centros/centro_m',
            'files/file_folders_m'
        ));
        
       	$this->validation_rules = array(
			    	
					array(
						'field' => 'nombre',
						'label' => 'Nombre',
						'rules' => 'trim|required'
						),
                    array(
						'field' => 'rama',
						'label' => 'Rama',
						'rules' => 'trim'
						),
     	            array(
						'field' => 'descripcion',
						'label' => 'Descripcion',
						'rules' => 'trim'
						),
                    array(
						'field' => 'video',
						'label' => 'Video',
						'rules' => 'trim'
						),
                     array(
						'field' => 'galeria',
						'label' => 'Galeria',
						'rules' => 'trim'
						),
                     array(
						'field' => 'fecha',
						'label' => 'Fecha',
						'rules' => 'trim'
						),
                     array(
						'field' => 'horario',
						'label' => 'Horario',
						'rules' => 'trim'
						),
                       array(
						'field' => 'tipo',
						'label' => 'Tipo',
						'rules' => 'trim|required'
						),
                         array(
						'field' => 'min',
						'label' => 'Mínimo participantes',
						'rules' => 'integer|required'
						),
                         array(
						'field' => 'max',
						'label' => 'Máximo participantes',
						'rules' => 'integer|required'
						),
                        array(
						'field' => 'activo',
						'label' => 'Activo',
						'rules' => 'trim|required'
						),
         );
         
        $tipos = array('cultural'=>'Cultural','civico'=>'Cívico','deportivo'=>'Deportivo','conocimiento'=>'Conocimiento','academico'=>'Académico');
        $ramas = array(
            0=> 'Indistinto',
            1=> 'Varonil',
            2=> 'Femenil',
            3=> 'Varonil y Femenil'
        );
        $this->template->set('ramas',$ramas)
                ->set('tipos',$tipos);
        
    }
    
    function index()
    {
        
    }
    function load($id)
    {
        $base_where = array();
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
        
        $disciplinas = $this->disciplina_m->order_by('nombre')
                        ->where($base_where)
                        ->like($base_like)
                        ->get_many_by(array('id_evento'=>$id));
        
        $this->template->set('id',$id)
                ->set('disciplinas',$disciplinas)
                ->build('admin/disciplinas/index');
    }
    function edit($id=0)
    {
        $disciplina = $this->disciplina_m->get($id);
        
        $this->form_validation->set_rules($this->validation_rules);        
        
        
		if($this->form_validation->run())        
        {
			unset($_POST['btnAction']);
            
            $input = array(
                'nombre'      =>$this->input->post('nombre'),
                'rama'        =>$this->input->post('rama'),
                'galeria'     => $this->input->post('galeria'),
                'descripcion' => $this->input->post('descripcion'),
                'video'       => $this->input->post('video'),
                'fecha'       => $this->input->post('fecha')?$this->input->post('fecha'):null,
                'horario'       => $this->input->post('horario'),
                'tipo'        => $this->input->post('tipo'),
                'activo'        => $this->input->post('activo'),
                'min'     => $this->input->post('min'),
                'max'     => $this->input->post('max'),
            );
            if($this->disciplina_m->update($id,$input))
            {
				
				$this->session->set_flashdata('success',lang('global:save_success'));
				
			}else{
				$this->session->set_flashdata('error',lang('global:save_error'));
				
			}
			redirect('admin/medallero/disciplinas/edit/'.$id);
        }
        
        $centros = $this->centro_m->dropdown('id','nombre');
        
        $folders = $this->file_folders_m->where('parent_id',3)->dropdown('slug','name');
        
        $this->template->set('id',$disciplina->id_evento)
                ->append_js('module::medallero.controller.js')
                ->set('centros',$centros)
                ->set('folders',$folders)
                ->set('disciplina',$disciplina)
                ->build('admin/disciplinas/form');
    }
    function create($id=0)
    {
        
        $disciplina = new StdClass();
        
        $this->form_validation->set_rules($this->validation_rules);
        
        
        
		if($this->form_validation->run())        
        {
			unset($_POST['btnAction']);
            
            $input = array(
                'nombre'      => $this->input->post('nombre'),
                'rama'        =>$this->input->post('rama'),
                'id_evento'   => $id,
                'galeria'     => $this->input->post('galeria'),
                
                'min'     => $this->input->post('min'),
                'max'     => $this->input->post('max'),
                
                'descripcion' => $this->input->post('descripcion'),
                'video'       => $this->input->post('video'),
                'fecha'       => $this->input->post('fecha')? $this->input->post('fecha'):null,
                'horario'       => $this->input->post('horario'),
                'tipo'        => $this->input->post('tipo'),
                'activo'        => $this->input->post('activo'),
            );
            if($this->disciplina_m->insert($input))
            {
				
				$this->session->set_flashdata('success',sprintf(lang('disciplina:save_success'),$input['nombre']));
				
			}else{
				$this->session->set_flashdata('error',lang('global:save_error'));
				
			}
			redirect('admin/medallero/disciplinas/'.$id);
        }
        foreach ($this->validation_rules as $rule)
		{
			$disciplina->{$rule['field']} = set_value($rule['field']);
		}
        $centros = $this->centro_m->dropdown('id','nombre');
        $folders = $this->file_folders_m->where('parent_id',3)->dropdown('slug','name');
        $this->input->is_ajax_request()
			?$this->template->set('id',$id)
                ->set('centros',$centros)
                ->set('disciplina',$disciplina)
                ->build('admin/disciplinas/form')
            :$this->template->set('id',$id)
                ->set('centros',$centros)
                ->set('folders',$folders)
                ->set('disciplina',$disciplina)
                ->build('admin/disciplinas/form');
    }
    
    function delete($id_evento=0,$id=0)
    {
         $medallero = $this->db->where('id_disciplina',$id)->get('medallero')->result();
        
		if (!$medallero && $success = $this->disciplina_m->delete($id))
		{
			// Fire an event. A group has been deleted.
			//Events::trigger('group_deleted', $id);
           
            
            
			$this->session->set_flashdata('success', lang('global:delete_success'));
		}
		else
		{
			$this->session->set_flashdata('error', lang('global:delete_error'));
		}

		redirect('admin/medallero/disciplinas/'.$id_evento);
    }
    public function action()
	{
		switch ($this->input->post('btnAction'))
		{
			case 'deactivate':
				$this->deactivate();
			break;

			

			
		}
	}
    
    function deactivate($id=0)
    {
        $ids = ($id) ? array($id) : $this->input->post('action_to');
        
        $url_return = $this->input->post('url_return');
        $activates  = array();
        
        foreach($ids as $id)
        {
            $disc = $this->disciplina_m->get($id);
            
            if($disc)
            {
                $this->disciplina_m->update($id,array('activo'=>'0'));
                
                $activates[] = $disc->nombre;
            }
        }
        
        redirect($url_return);
    }
 }
 ?>