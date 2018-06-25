<?php

namespace Drupal\fossee_institute_profiles\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\InvokeCommand;

class MainForm extends FormBase {

  public function buildForm(array $form, FormStateInterface $form_state) {
    global $base_url;
    $form['clg'] = array(
        '#type' => 'textfield',
        '#title' => '',
        '#maxlength' => 60,
        '#prefix' => '<div class="container-inline">',
        '#autocomplete_path' => 'clg/autocomplete',
        '#attributes'=>array(
            'elem-style'=>'SearchBox',
            'list'=>'suggestion',
            'onkeyup'=>'Search(event,this,\''.$base_url.'\')',
            'autocomplete'=>'off'
        )
    );
    // Search button
    $form['submit'] = array(
        '#type'=>'submit',
        '#value'=>'Q',
        '#ajax'=>array(
            'callback'=>'::ajaxSearch'
        ),
        '#attributes'=>array(
            'elem-style'=>'SearchButton'
        )
    );
    // Reset button
    $form['reset'] = array(
        '#type'=>'inline_template',
        '#template'=>'<input type="button" value="Reset" onclick="ClearSearch()" elem-style="ResetButton"></div>'
    );
    $form['suggestion'] = array(
        '#type'=>'inline_template',
        '#template'=>'<datalist id="suggestion"></datalist>'
    );
    if(isset( $_GET['c'] ) )
        $form['divs']=array(
            '#type'=>'inline_template',
        '#template'=>'<div id="cProfile">'.$this->fossee_institute_profiles_display($_GET['c']).'</div>');
    else
        $form['divs']=array('#type'=>'inline_template',
        '#template'=>'<div id="cProfile" style="display:none"></div>');
    $form['#attached']['library'][] = 'fossee_institute_profiles/thedata';
    return $form;
  }
  public function getFormId() {    return 'main_form';  }
    function fossee_institute_profiles_display($val){
        global $base_url;
        $lab = '';  // Lab Migration Html
        $state = ''; // State of the colege
        $country = ''; // Country of the college
        $city = ''; // City of the college
        $work = ''; // Worshop html
        $text = ''; // Text book html
        $ckt = ''; // Circuit Simulation Html
        $flow = ''; // Flowsheeting HTMl
        $caseS = ''; // Case Study HTML

        $li = 1;
        $ci = 1;
        $ti = 1;
        $wi = 1;
        $fi = 1;
        $connection = \Drupal::database();
        // Get City,State,Country of a College
        $query = $connection->query('SELECT city,state,country FROM fossee_new.clg_names WHERE name = :args',array(
            ':args'=>$val
        ));
        $row = $query->fetchAll();
        foreach($row as $r){
            if($this->IS_EMPTY($city) || $this->IS_EMPTY($state) || $this->IS_EMPTY($country)){
                $city = $r->city;
                $state = $r->state;
                $country = $r->country;
            }
        }
        // Get workshop id,name 
        $query = $connection->query('SELECT w_id,w_name FROM workshop WHERE venue LIKE :args;',array(
            ':args'=>'%'.$val.'%'
        ));
        $rows = $query->fetchAll();
        $Fpage = $base_url.'/'; // Get the front url
        foreach($rows as $row){
            $work .= '<tr><td>'.$wi.'</td><td>';
            $work .= '<a href="'.$Fpage.'workshop/view/'.$row->w_id.'" >'.$row->w_name.'</a><br>';
            $wi++;
            $work .= '</td></tr>';
        }
        /************************************ Scilab *************/
        \Drupal\Core\Database\Database::setActiveConnection('Scilab');
        $connection = \Drupal\Core\Database\Database::getConnection('Scilab');
        // Get  Lab title,id
        $query = $connection->query('SELECT id,lab_title FROM lab_migration_proposal WHERE university LIKE :arg',array(
            ':arg'=>'%'.$val.'%'
        ));
        $rows = $query->fetchAll();
        foreach($rows as $row){
            $lab .= '<tr><td>'.$li.'</td><td>';
            $lab .= '<a href="'.$Fpage.'lab-data/scilab/'.$row->id.'" >'.$row->lab_title.'</a>';
            $li++;
            $lab .= '</td></tr>';
        }
        // Get book,author,id
        $query = $connection->query('SELECT pe.book as book,pe.author as author,pe.id as id FROM textbook_companion_proposal po left join textbook_companion_preference pe on po.id = pe.proposal_id WHERE university LIKE :arg AND pe.id IS NOT NULL',array(
            ':arg'=>'%'.$val.'%'
        ));
        $rows = $query->fetchAll();
        foreach($rows as $row){
            $text .= '<tr><td>'.$ti.'</td><td>';
            $text .= '<a href="'.$Fpage.'textbook/scilab/'.$row->id.'" >'.$row->book.' By '.$row->author.'</a>';
            $text .= '</td></tr>';
            $ti++;
        }
        /**************************** openmodelica */
        \Drupal\Core\Database\Database::setActiveConnection('OpenModelica');
        $connection = \Drupal\Core\Database\Database::getConnection('OpenModelica');
        // Get openmodelica lab id,title
        $query = $connection->query('SELECT id,lab_title FROM lab_migration_proposal WHERE university LIKE :arg',array(
            ':arg'=>'%'.$val.'%'
        ));
        $rows = $query->fetchAll();
        foreach($rows as $row){
            $lab .= '<tr><td>'.$li.'</td><td>';
            $lab .= '<a href="'.$Fpage.'lab-data/openmodelica/'.$row->id.'" >'.$row->lab_title.'</a>';
            $lab .= '</td></tr>';
            $li++;
        }
            // Get id,book,author
        $query = $connection->query('SELECT pe.book as book,pe.author as author,po.id as id FROM textbook_companion_proposal po left join textbook_companion_preference pe on po.id = pe.proposal_id WHERE university LIKE :arg AND po.id IS NOT NULL',array(
            ':arg'=>'%'.$val.'%'
        ));
        $rows = $query->fetchAll();
        foreach($rows as $row){
            $text .= '<tr><td>'.$ti.'</td><td>';
            $text .= '<a href="'.$Fpage.'/textbook/openmodelica/'.$row->id.'" >'.$row->book.' By '.$row->author.'</a>';
            $text .= '</td></tr>';
            $ti++;
        }

        /*********************************************Dwsim */
        \Drupal\Core\Database\Database::setActiveConnection('DWSIM');
        $connection = \Drupal\Core\Database\Database::getConnection('DWSIM');
        // Get lab id,title
        $query = $connection->query('SELECT id,lab_title FROM lab_migration_proposal WHERE university LIKE :arg',array(
            ':arg'=>'%'.$val.'%'
        ));
        $rows = $query->fetchAll();
        foreach($rows as $row){
            $lab .= '<tr><td>'.$li.'</td><td>';
            $lab .= '<a href="'.$Fpage.'lab-data/dwsim/'.$row->id.'" >'.$row->lab_title.'</a>';
            $lab .= '</td></tr>';
            $li++;
        }
            // Get book,id,author
        $query = $connection->query('SELECT pe.book as book,pe.author as author,po.id as id FROM textbook_companion_proposal po left join textbook_companion_preference pe on po.id = pe.proposal_id WHERE university LIKE :arg AND po.id IS NOT NULL',array(
            ':arg'=>'%'.$val.'%'
        ));
        $rows = $query->fetchAll();
        foreach($rows as $row){
            $text .= '<tr><td>'.$ti.'</td><td>';
            $text .= '<a href="'.$Fpage.'textbook/dwsim/'.$row->id.'" >'.$row->book.' By '.$row->author.'</a>';
            $text .= '</td></tr>';
            $ti++;
        }
        // Flowsheeting projects
        $query = $connection->query('SELECT id,project_title From dwsim_flowsheet_proposal WHERE university LIKE :args',array(
            ':args'=>'%'.$val.'%'
        ));
        $rows = $query->fetchAll();
        // Flowsheeting project links
        foreach($rows as $row){
            $flow .= '<tr><td>'.$fi.'</td><td>';
            $flow .= '<a href="'.$Fpage.'flow/'.$row->id.'" >'.$row->project_title.'</a><br>';
            $flow .= '</td></tr>';
            $fi++;
        }

        /**********************OpenFOAM****************/
        \Drupal\Core\Database\Database::setActiveConnection('OpenFOAM');
        $connection = \Drupal\Core\Database\Database::getConnection('OpenFOAM');
        // Get lab id,title
        $query = $connection->query('SELECT id,lab_title FROM lab_migration_proposal WHERE university LIKE :arg',array(
            ':arg'=>'%'.$val.'%'
        ));
        $rows = $query->fetchAll();
        foreach($rows as $row){
            $lab .= '<tr><td>'.$li.'</td><td>';
            $lab .= '<a href="'.$Fpage.'lab-data/openfoam/'.$row->id.'" >'.$row->lab_title.'</a>';
            $lab .= '</td></tr>';
            $li++;
        }
        // Get id,book,author
        $query = $connection->query('SELECT pe.book as book,pe.author as author,po.id as id FROM textbook_companion_proposal po left join textbook_companion_preference pe on po.id = pe.proposal_id WHERE university LIKE :arg AND po.id IS NOT NULL',array(
            ':arg'=>'%'.$val.'%'
        ));
        $rows = $query->fetchAll();
        foreach($rows as $row){
            $text .= '<tr><td>'.$ti.'</td><td>';
            $text .= '<a href="'.$Fpage.'textbook/openfoam/'.$row->id.'" >'.$row->book.' By '.$row->author.'</a>';
            $text .= '</td></tr>';
            $ti++;
        }
        /*************** Or Tools ************/
        \Drupal\Core\Database\Database::setActiveConnection('OR-Tools');
        $connection = \Drupal\Core\Database\Database::getConnection('OR-Tools');
        // Get id,author,book
        $query = $connection->query('SELECT pe.book as book,pe.author as author,po.id as id FROM textbook_companion_proposal po left join textbook_companion_preference pe on po.id = pe.proposal_id WHERE university LIKE :arg AND po.id IS NOT NULL',array(
            ':arg'=>'%'.$val.'%'
        ));
        $rows = $query->fetchAll();
        foreach($rows as $row){
            $text .= '<tr><td>'.$ti.'</td><td>';
            $text .= '<a href="'.$Fpage.'textbook/or/'.$row->id.'" >'.$row->book.' By '.$row->author.'</a>';
            $text .= '</td></tr>';
            $ti++;
        }

        /***************************** esim ********************* */
        \Drupal\Core\Database\Database::setActiveConnection('eSim');
        $connection = \Drupal\Core\Database\Database::getConnection('eSim');
        // Get esim lab id,title
        $query = $connection->query('SELECT id,lab_title FROM lab_migration_proposal WHERE university LIKE :arg',array(
            ':arg'=>'%'.$val.'%'
        ));
        $rows = $query->fetchAll();
        foreach($rows as $row){
            $lab .= '<tr><td>'.$li.'</td><td>';
            $lab .= '<a href="'.$Fpage.'lab-data/esim/'.$row->id.'" >'.$row->lab_title.'</a>';
            $lab .= '</td></tr>';
            $li++;
        }
        // Get esim book,id,author
        $query = $connection->query('SELECT pe.book as book,pe.author as author,po.id as id FROM textbook_companion_proposal po left join textbook_companion_preference pe on po.id = pe.proposal_id WHERE university LIKE :arg AND po.id IS NOT NULL',array(
            ':arg'=>'%'.$val.'%'
        ));
        $rows = $query->fetchAll();
        foreach($rows as $row){
            $text .= '<tr><td>'.$ti.'</td><td>';
            $text .= '<a href="'.$Fpage.'textbook/esim/'.$row->id.'" >'.$row->book.' By '.$row->author.'</a>';
            $text .= '</td></tr>';
            $ti++;
        }


        $query = $connection->query('SELECT id,project_title FROM esim_circuit_simulation_proposal WHERE university LIKE :args',array(
            ':args'=>'%'.$val.'%'
        ));
        $rows = $query->fetchAll();
        // circuit simulation links
        foreach($rows as $row){
            $ckt .= '<tr><td>'.$ci.'</td><td>';
            $ckt .= '<a href="'.$Fpage.'ckt/'.$row->id.'" >'.$row->project_title.'</a>';
            $ckt .= '</td></tr>';
            $ci++;
        }
        
        /*********************************** Display Data ******************/
        // Check wether state,city,country is empty
        if($this->IS_EMPTY($state))    $state = "----";
        if($this->IS_EMPTY($city))     $city = "----";
        if($this->IS_EMPTY($country))  $country = "----";
        // If data is empty display default
        if($this->IS_EMPTY($lab))      $lab =      '<b>No Lab Migration Done!</b>';
        if($this->IS_EMPTY($text))     $text =     '<b>No Textbook Companion Done!</b>';
        if($this->IS_EMPTY($work))     $work =     '<b>No Workshop Done!</b>';
        if($this->IS_EMPTY($ckt))      $ckt =      '<b>No Circuit Simulation Done!</b>';
        if($this->IS_EMPTY($flow))     $flow =     '<b>No Flowsheeting Projects Done!</b>';
        if($this->IS_EMPTY($caseS))    $caseS =    '<b>No Case Study Done!</b>';
        
        $out .= '<h1>'.$val.'</h1>';
        $out .= '<h3>( <b>Country : </b>'.$country.'<b> State :</b>'.$state.'<b> City : </b>'.$city.' )</h1>';
        $out .= '<ul id="thetabs">
        <li onclick=\'ChangeTab(1)\' class="active">Lab Migration</li>
        <li onclick="ChangeTab(2)">Textbook Companion</li>
        <li onclick="ChangeTab(3)">Workshop</li>
        <li onclick="ChangeTab(4)">Circuit Simulation</li>
        <li onclick="ChangeTab(5)">Flowsheeting Projects</li>
        <li onclick="ChangeTab(6)">Case Study Project</li></ul>';
        $out .= '<div id="thedata-1" style="display:block"><table class="table table-bordered table-hover">'.$lab.'</table></div>';
        $out .= '<div id="thedata-2" style="display:none"><table class="table table-bordered table-hover">'.$text.'</table></div>';
        $out .= '<div id="thedata-3" style="display:none"><table class="table table-bordered table-hover">'.$work.'</table></div>';
        $out .= '<div id="thedata-4" style="display:none"><table class="table table-bordered table-hover">'.$ckt.'</table></div>';
        $out .= '<div id="thedata-5" style="display:none"><table class="table table-bordered table-hover">'.$flow.'</table></div>';
        $out .= '<div id="thedata-6" style="display:none"><table class="table table-bordered table-hover">'.$caseS.'</table></div>';
        return $out;
    }
    public function IS_EMPTY($val){
        return ($val === '' || $val === 'None' || $val === '0' || $val === null);
    }
  public function ajaxSearch(array &$form, FormStateInterface $form_state)
  {
    $val = $form_state->getValue('clg');
    $ajax_response = new AjaxResponse();
    if(strlen(str_replace(" ","",$val)) > 3)
        $ajax_response->addCommand(new InvokeCommand(NULL, 'DisplayData', [$this->fossee_institute_profiles_display($val)]));
    else
        $ajax_response->addCommand(new InvokeCommand(NULL, 'DIsplayNone', []));

    return $ajax_response;
  }
  public function validateForm(array &$form, FormStateInterface $form_state){}
  public function submitForm(array &$form, FormStateInterface $form_state) {}
}