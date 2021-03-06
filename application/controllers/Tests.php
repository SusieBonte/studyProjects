<?php 
	class Tests extends CI_Controller
	{	
		public function index()
		{
			$data['title'] = 'Tests';
			
			$data['tests'] = $this->test_model->get_tests();
			
			$this->load->view('templates/header');
			$this->load->view('tests/index', $data);
			$this->load->view('templates/footer');
		}
	
		public function create()
		{
			$this->check_privy();
			
			$this->load->view('templates/header');
			$this->load->view('tests/testadmin');
			$this->load->view('templates/footer');
		}
		
		public function create_test()
		{
			$this->check_privy();
			
			$crud = new grocery_CRUD();
					
			$crud->set_table('tests');
			
			
			$crud->fields('test_name','user_id');
			$crud->change_field_type('user_id','invisible');
			$crud->required_fields('test_name');
			$crud->columns('test_name');
			
			$crud->callback_before_insert(function($post_array){
				$post_array['user_id'] = $this->session->userdata('user_id');
				return $post_array;
			});
			
			$output = $crud->render();
			
			$this->load->view('templates/header');
			$this->load->view('tests/create', $output);
			$this->load->view('templates/footer');
			
			
			
		}
		
		public function create_subsection()
		{
			$this->check_privy();
			
			$crud = new grocery_CRUD();
					
			$crud->set_table('test_subsection');
			$crud->fields('test_id','subsection_name');
			$crud->required_fields('test_id','subsection_name');
			$crud->columns('test_id','subsection_name');
			
			$crud->set_relation('test_id','tests','test_name');
			$crud->display_as('test_id','Test');
			$output = $crud->render();
			
			$this->load->view('templates/header');
			$this->load->view('tests/create', $output);
			$this->load->view('templates/footer');
			
		}
		
		public function create_question()
		{
			$this->check_privy();
			
			$crud = new grocery_CRUD();
					
			$crud->set_table('questions');
			$crud->fields('subsection_id','question_text');
			
			$crud->columns('subsection_id','question_text');
			
			$crud->set_relation('subsection_id','test_subsection','subsection_name');
			$crud->display_as('subsection_id','Subsection');
			$output = $crud->render();
			
			$this->load->view('templates/header');
			$this->load->view('tests/create', $output);
			$this->load->view('templates/footer');			
		}
		
		public function create_answers()
		{
			$this->check_privy();
			
			$crud = new grocery_CRUD();
					
			$crud->set_table('answers');
			$crud->fields('question_id','answer_text','is_correct');
			$crud->required_fields('question_id','answer_text');
			$crud->columns('question_id','answer_text');
			
			$crud->set_relation('question_id','questions','question_text');
			$crud->display_as('question_id','Question');
			$output = $crud->render();
			
			$this->load->view('templates/header');
			$this->load->view('tests/create', $output);
			$this->load->view('templates/footer');			
		}
		
		public function take($test_id, $question_offset)
		{
			if(!$this->session->userdata('logged_in'))
			{
				redirect('users/login');	
			}
			
			
			$questions = $this->test_model->get_questions($test_id, $question_offset);
			
			foreach($questions as $question)
			{
				$answers = $this->test_model->get_answers($question->question_id);
				$question->answers = $answers;
			}
			
			
			$this->load->view('templates/header');
			$this->load->view('tests/take', ['test_id' => $test_id, 'question_offset' => $question_offset, 'questions' => $questions]);
			$this->load->view('templates/footer');		
		}
		
		public function take_begin($test_id)
		{
			
			$_SESSION['quiz'][$test_id] = [];
			$this->load->view('templates/header');
			$this->load->view('tests/take_begin', ['test_id' => $test_id]);
			$this->load->view('templates/footer');	
		}
		
		public function check_privy()
		{
			if(!$this->session->userdata('logged_in') || $this->session->userdata('privy') != 'admin')
			{
				redirect('users/login');
			}
		}
	}