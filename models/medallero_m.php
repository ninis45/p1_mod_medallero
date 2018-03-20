<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Medallero_m extends MY_Model {

	private $folder;
    private $update = array();
	public function __construct()
	{
		parent::__construct();
		$this->_table = 'medallero';
		
	}
    function edit($id,$input)
    {
        $data = array(
                'id_centro'     => $input['id_centro'],
                'participante'  => $input['participante'],
                'posicion'      => $input['posicion'],
                
        );
        
        return $this->medallero_m->update($id,$data);
    }
    function add($id_evento,$id_disciplina,$input)
    {
            $data = array(
                'id_centro'     => $input['id_centro'],
                'participante'  => $input['participante'],
                'posicion'      => $input['posicion'],
                'id_evento'     => $id_evento,
                'id_disciplina' => $id_disciplina,
            );
            
            $exits = true;
            $new_position = false;
            
            while($exits):
                 $new_position = $new_position?$new_position :$data['posicion'];
                 
                 if($row = $this->get_by(array(
                    'id_evento' => $id_evento,
                    'id_disciplina' => $id_disciplina,
                    'posicion'      => $new_position
                    
                )))
                {
                    $new_position = $new_position+1;
                    
                    $this->update[] = array('posicion'=>$new_position,'id'=>$row->id);
                    
                    
                }
                else
                {
                    $exits = false;
                }
            endwhile;
           
            foreach($this->update as $update)
            {
                $this->db->where('id',$update['id'])->set($update)->update($this->_table);
            }
            
           return $this->medallero_m->insert($data);
    }
 }
 ?>