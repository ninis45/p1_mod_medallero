<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Search Plugin
 *
 * Use the search plugin to display search forms and content
 *
 * @author  PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Search\Plugins
 */
class Plugin_Medallero extends Plugin
{
	public $version = '1.0.0';

	public $name = array(
		'en' => 'Search',
            'fa' => 'جستجو',
	);

	public $description = array(
		'en' => 'Create a search form and display search results.',
        'fa' => 'ایجاد فرم جستجو و نمایش نتایج',
	);
    public function __construct()
	{
		$this->load->model(array(
			'medallero_m',
			'disciplina_m'
		));
        
        $this->load->library('files/files');
	}
    
    function get_medallero()
    {
        $id_evento = $this->attribute('id','');
        $limit     = $this->attribute('limit','');
        $tipo      = $this->attribute('tipo','');
        
       
        
        if(!is_numeric($id_evento))
        {
            $evento = $this->db->where('slug',$id_evento)->get('eventos')->row();
            
           
            $id_evento = $evento->id;
        }
        
        $disciplinas = $this->disciplina_m
                                ->where(array(
                                     'id_evento' => $id_evento,
                                     'tipo'     => $tipo
                                ))->get_all();
        
        if($disciplinas)
        {
            foreach($disciplinas as &$disciplina)
            {
                $disciplina->participantes = $this->medallero_m->select('*,centros.nombre AS nombre_centro')->join('centros','centros.id=medallero.id_centro')->limit($limit)->order_by('posicion')->get_many_by(array(
                
                    'id_disciplina' => $disciplina->id,
                ));
            }
            
           
            return $disciplinas;
        }
        
        return false;
    }
    function list_disciplinas()
    {
        return $this->disciplina_m->get_all();
        
        
    }
    function get_disciplina()
    {
        $id = $this->input->get('disc');
        
        $disciplinas = $this->disciplina_m->limit(1)
                        ->get_many_by(array('id'=>$id));
        
        if($disciplinas)
        {
            foreach($disciplinas as &$disciplina)
            {
                if($disciplina->galeria)
                {
                    $folder = $this->file_folders_m->get_by_path('galeria/'.$disciplina->galeria);
                    
                    if($folder)
                    {
                        $galeria =  Files::folder_contents($folder->id);
                        $disciplina->galeria = $galeria['data']['file'];
                    }
                }
                if($disciplina->horario)
                {
                    list($h_ini,$h_fin) = explode('-',$disciplina->horario);
                    
                    $timestamp = strtotime($disciplina->fecha.' '.$h_ini);
                    
                    $disciplina->timestamp_end = strtotime($disciplina->fecha.' '.$h_fin);
                    $disciplina->date_countdown =  format_date($timestamp,'M d,Y H:i:s');
                }
                
                $disciplina->date_calendar = format_date_calendar($disciplina->fecha);
                
                $disciplina->participantes = $this->medallero_m->select('*,centros.nombre AS nombre_centro')->join('centros','centros.id=medallero.id_centro')->order_by('posicion')->get_many_by(array(
            
                    'id_disciplina' => $disciplina->id
                ));
            }
            
           
            return $disciplinas;
        }
        //$this->template->append_metadata('<script type="text/javascript">var _messageAfterCount = "El evento ha comenzado!";</script>');
        return false;
        
    }
 }
 ?>