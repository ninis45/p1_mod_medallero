<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Groups module
 *
 * @author PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Groups
 */
 class Module_Medallero extends Module
{

	public $version = '1.0';

	public function info()
	{
		$info= array(
			'name' => array(
				'en' => 'Ads',
				
				'es' => 'Medallero',
				
			),
			'description' => array(
				'en' => 'N/A',
				
				'es' => 'Visualiza la tabla de posiciones de diferentes disciplinas',
				
			),
			'frontend' => false,
			'backend' => true,
			'menu' => 'admin',
            'roles' => array(
				
			),
            'sections'=>array(
                'medallero'=>array(
                    'name'=>'medallero:title',
                    'ng-if'=>'hide_shortcuts',
                    'uri' => 'admin/medallero/{{ id }}',
        			'shortcuts' => array(
        				array(
        					'name' => 'medallero:create',
        					'uri' => 'admin/medallero/create/{{ id }}?modal=true',
        					'class' => 'btn btn-success',
                            'open-modal'=>'',
                            'modal-title'=>'Disciplinas',
        				),
                       
        			)
                )
           )
		);
        
        if (function_exists('group_has_role'))
		{
			if(group_has_role('fondo', 'admin_disciplinas'))
			{
			    
				$info['sections']['disciplinas'] = array(
							'name' 	=> 'disciplinas:title',
							'uri' 	=> 'admin/medallero/disciplinas/{{ id }}',
							'shortcuts' => array(
									'create' => array(
										'name' 	=> 'disciplinas:create',
										'uri' 	=> 'admin/medallero/disciplinas/create/{{ id }}',
										'class' => 'btn btn-success'
									)
							)
				);
			}
		}
        
        
        return $info;
	}

	public function install()
	{
	    $this->dbforge->drop_table('medallero');
        $this->dbforge->drop_table('disciplinas');
        
		$tables = array(
		    'medallero'=>array(
				'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true,),
                'id_evento' => array('type' => 'INT', 'constraint' => 11,'null'=>true),
                'id_disciplina' => array('type' => 'INT', 'constraint' => 11,'null'=>true),
                'id_centro' => array('type' => 'INT', 'constraint' => 11,'null'=>true),
				'participante' => array('type' => 'TEXT', 'null' => true,),
                'posicion' => array('type' => 'INT', 'constraint' => 11, 'null' => true,),
                //'medalla' => array('type' => 'VARCHAR', 'constraint' => 254,'null' => true,),
                
				
            ),
            
            'disciplinas'=>array(
            
                'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true,),
                'id_evento' => array('type' => 'INT', 'constraint' => 11,'null'=>true),
                'nombre' => array('type' => 'VARCHAR','constraint' => 255, 'null' => true,),
                'descripcion' => array('type' => 'TEXT', 'null' => true,),
                'galeria' => array('type' => 'VARCHAR','constraint' => 255, 'null' => true,),
                'video' => array('type' => 'VARCHAR','constraint' => 255, 'null' => true,),
                'fecha' => array('type' => 'DATE','null' => true,),
                'horario' => array('type' => 'VARCHAR','constraint' => 255, 'null' => true,),
                
            )
			
		);
        
        if ( ! $this->install_tables($tables))
		{
			return false;
		}

        return true;
        
		

		
	}

	public function uninstall()
	{
	  
        $this->dbforge->drop_table('medallero');
        $this->dbforge->drop_table('disciplinas');
		return true;
	}

	public function upgrade($old_version)
	{
		return true;
	}

}
?>