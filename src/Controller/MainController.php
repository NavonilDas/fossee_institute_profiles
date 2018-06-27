<?php

namespace Drupal\fossee_institute_profiles\Controller;
 
use Drupal\Core\Controller\ControllerBase;

class MainController extends ControllerBase {
  public function getAllClg() {
    global $base_url;
    $out = ''; // output html
    $all = 0; // All counts
    $s = 0; // Current Page index
    // Get the Page Index
    if(isset($_GET['page'])) $s = (int)$_GET['page'] - 1;
    if($s<0) $s = 0;

    $connection = \Drupal::database();

    // Get the no of total colleges
    $query = $connection->query('SELECT count(name) as count FROM clg_names');
    $rows = $query->fetchAll();
    $Fpage = $base_url.'/';
    //$Fpage = drupal_get_normal_path(url()); // Get the front url
    $all = (int)$rows[0]->count;
    $last = round($all/25);
    // if the Index given is greater than total display error
    if($s > $last-1) return '<b>Error Page Not Found</b>';
    /// Add the css
    // drupal_add_css(drupal_get_path('module','fossee_institute_profiles').'/fossee_profiles.css');
    // Get 25 rows 
    $query = $connection->query('SELECT name FROM clg_names ORDER BY name ASC LIMIT 25 OFFSET '.($s*25));
    $rows = $query->fetchAll();
    $i = 1;
    $out .= '<table class="table table-bordered table-hover">';
    // Diplay each college name with their link
    foreach($rows as $row){
        $out .= '<tr>';
        $out .= '<td>'.($s*25+$i).'</td>';
        $out .= '<td><a href="'.$Fpage.'cProfiles?c='.str_replace(' ','%20', $row->name).'" >'.$row->name.'</a></td>';
        $i++;
        $out .= '</tr>';
    }
    $out.='</table>';
    // Display the front Page
    $out .= '<div id="theRow"><a href="'.$Fpage.'cProfiles/all?page=1">First</a>';
    // Display the Prev Button if it is not the first page
    if($s > 0)
        $out .= '<a href="'.$Fpage.'cProfiles/all?page='.($s).'">&lt;</a>';
    
    $diff = $last - $s - 7;
    if($diff > 0) $Si = 1;
    else $Si = $diff + 1;
    // Display Next Five links 
    for($j=$Si;$j<5+$Si;$j++){
        if($s+$j+1 <= $last)
        $out .= '<a href="'.$Fpage.'cProfiles/all?page='.($s+$j+1).'">'.($s+$j+1).'</a>';
    }
    // Display Next Button if it is not the last page
    if($s < $last-1)
        $out .= '<a href="'.$Fpage.'cProfiles/all?page='.($s+2).'">&gt;</a>';
    //Display the last Page
    $out .= '<a href="'.$Fpage.'cProfiles/all?page='.$last.'">Last</a></div>';

    $render_array['resume_arguments'] = array(
      '#markup' => $out,
      
    );
    $render_array['#attached']['library'][] = 'fossee_institute_profiles/thedata';
    return $render_array;
  }
  function getFlowsheeting($id = 0){
      global $base_url;
    $out = ''; // output html
    //DWSIM
    \Drupal\Core\Database\Database::setActiveConnection('DWSIM');
    $connection = \Drupal\Core\Database\Database::getConnection('DWSIM');
    $query = $connection->query('SELECT * FROM dwsim_flowsheet_proposal WHERE id = :arg',array(":arg"=>$id));
    // dpm($query->fetchAll());
    //$query = $connection->query('SELECT id,approval_status,project_title,name_title,contributor_name,university,reference FROM dwsim_flowsheet_proposal WHERE id='.$id);
    $rows = $query->fetchAll();
    $Fpage = $base_url.'/';
    // Count the no of rows if rows exist then display data
    if(count($rows) > 0){
        // Add the css File
        if(!$this->IS_EMPTY($rows[0]->project_title)) 
            $out .= '<b>Title : </b>'.$rows[0]->project_title.'<br>';
        $out .= '<b>Proposed By : </b>'.$rows[0]->name_title.' '.$rows[0]->contributor_name.'<br>';
        if(!$this->IS_EMPTY($rows[0]->university))
            $out .= '<b>University : </b>'.$rows[0]->university.'<br>';
        if(!$this->IS_EMPTY($rows[0]->reference))
            $out .= '<b>Reference : </b>'.$rows[0]->reference.'<br>';
        if($rows[0]->approval_status == 3)
            $out .= '<b>Progress : </b>Completed<br>';
        else 
            $out .= '<b>Progress : </b>In Progress<br>';
        if($rows[0]->approval_status == 3)
            $out .= '<a href="https://dwsim.fossee.in/flowsheeting-project/dwsim-flowsheet-run/'.$rows[0]->id.'"  id="rButton">Main Website</a>';
        $out .= '<a href="'.$Fpage.'cProfiles"  id="lButton">Back</a>';
        }
        $render_array['resume_arguments'] = array(
            '#markup' => $out,
            
          );
          $render_array['#attached']['library'][] = 'fossee_institute_profiles/thedata';
          return $render_array;
  }

  function getWorkshop($wid){
    global $base_url;
    \Drupal\Core\Database\Database::setActiveConnection('default');
    $connection = \Drupal::database();
    $query = $connection->query('SELECT w_name,startdate,enddate,no_of_participant,venue,event_link,body FROM workshop WHERE w_id = :args',array(
        ':args'=>$wid
    ));
    $rows = $query->fetchAll();
    $out = '<b>NO Data Find!</b>'; // Output HTML
    $Fpage = $base_url.'/';

    if(count($rows) > 0){        
        $out = '<table class="table table-bordered table-hover">';
        if(!$this->IS_EMPTY($rows[0]->w_name))
            $out .= '<tr><td><b>Name</b></td><td>'.$rows[0]->w_name.'</td></tr>';
        if(!$this->IS_EMPTY($rows[0]->startdate))
            $out .= '<tr><td><b>Start Date</b></td><td>'.$rows[0]->startdate.'</td></tr>';
        if(!$this->IS_EMPTY($rows[0]->enddate))
            $out .= '<tr><td><b>End Date</b></td><td>'.$rows[0]->enddate.'</td></tr>';
        if(!$this->IS_EMPTY($rows[0]->no_of_participant))
            $out .= '<tr><td><b>No. of Participants</b></td><td>'.$rows[0]->no_of_participant.'</td></tr>';
        if(!$this->IS_EMPTY($rows[0]->venue))
            $out .= '<tr><td><b>Venue</b></td><td>'.$rows[0]->venue.'</td></tr>';
        if(!$this->IS_EMPTY($rows[0]->event_link))
            $out .= '<tr><td><b>Events Website</b></td><td>'.$rows[0]->event_link.'</td></tr>';    
        if(!$this->IS_EMPTY($rows[0]->body))
            $out .= '<tr><td><b>Details</b></td><td>'.$rows[0]->body.'</td></tr>';
        $query = $connection->query('SELECT w_id,path FROM workshop_images WHERE w_id = :args',array(
            ':args'=>$wid
        ));
        $rows = $query->fetchAll();
        $rl = count($rows);
        // DIsplay Images
        if($rl > 0)     $out .= '<tr><td><b>Images</b></td><td>';
        foreach($rows as $row){
            if(strpos($row->path,'events_images') !== false)
            $out .= '<img src="'.$Fpage.str_replace('/Site/fossee_drupal','',$row->path).'" alt="IMG"  class="wimg" onclick="viewImage(this)"/>';
            else $out .= '<img src="'.$Fpage.'events_images/'.str_replace('/Site/fossee_drupal','',$row->path).'" alt="IMG" class="wimg" onclick="viewImage(this)"/>';
        }    
        if($rl > 0)
            $out .= '</td></tr>';
        $out .= '</table>';
        $out .= '<a href="'.$Fpage.'cProfiles"  id="lButton">Back</a>';

        // Image viewbox
        if($rl > 0)$out .= '<div id="ViewContainer"><div id="VIewBox"></div></div>';
    }
    $render_array['resume_arguments'] = array(
        '#type'=>'inline_template','#template' => $out,
      );
      $render_array['#attached']['library'][] = 'fossee_institute_profiles/thedata';
      return $render_array;
  }

  function getLabData($type = '',$id = 0){
    global $base_url;
    if($type == 'scilab') $ltype = 'Scilab';
    else if($type == 'esim') $ltype = 'eSim';
    else if($type == 'dwsim') $ltype = 'DWSIM';
    else if($type == 'openmodelica') $ltype = 'Open Modelica';
    else if($type == 'openfoam') $ltype = 'OpenFOAM';
    else $ltype = 'Others';

    $db = '';
    if($type == 'openmodelica') $db = 'OpenModelica';
    else if($type == 'or') $db = 'OR-Tools';
    else $db = $ltype;
    \Drupal\Core\Database\Database::setActiveConnection($db);
    $connection = \Drupal\Core\Database\Database::getConnection($db);

    $out = ''; // Output HTML
    $qstr = 'SELECT * FROM lab_migration_proposal WHERE id = '.$id;
    $query = $connection->query($qstr);
    $rows = $query->fetchAll();
    $rl = count($rows);
    $Fpage = $base_url.'/';
    if($rl > 0){
        // Display Data in Table format
        $out = '<table class="table table-bordered table-hover">';
        if(!$this->IS_EMPTY($rows[0]->lab_title))
            $out .= '<tr><td><b>Title</b></td><td>'.$rows[0]->lab_title.'</td></tr>';        
        $out .= '<tr><td><b>Lab Type</b></td><td>'.$ltype.'</td></tr>';        
        if(!$this->IS_EMPTY($rows[0]->name))
            $out .= '<tr><td><b>By</b></td><td>'.$rows[0]->name_title.' '.$rows[0]->name.'</td></tr>';        
        if(!$this->IS_EMPTY($rows[0]->department))
            $out .= '<tr><td><b>Department</b></td><td>'.$rows[0]->department.'</td></tr>';        
        if(!$this->IS_EMPTY($rows[0]->university))
            $out .= '<tr><td><b>University</b></td><td>'.$rows[0]->university.'</td></tr>';        
        if(!$this->IS_EMPTY($rows[0]->city))
            $out .= '<tr><td><b>City</b></td><td>'.$rows[0]->city.'</td></tr>';
        if(!$this->IS_EMPTY($rows[0]->pincode))
            $out .= '<tr><td><b>Pin Code</b></td><td>'.$rows[0]->pincode.'</td></tr>';        
        if(!$this->IS_EMPTY($rows[0]->state))
            $out .= '<tr><td><b>State</b></td><td>'.$rows[0]->state.'</td></tr>';        
        if(!$this->IS_EMPTY($rows[0]->country))
            $out .= '<tr><td><b>Country</b></td><td>'.$rows[0]->country.'</td></tr>'; 
        
        if($rows[0]->approval_status == 3)     
            $out .= '<tr><td><b>Progress</b></td><td>Completed</td></tr>';      
        else if($rows[0]->approval_status == 5)
            $out .= '<tr><td><b>Progress</b></td><td>Under Observation</td></tr>';
        else
            $out .= '<tr><td><b>Progress</b></td><td>In Progress</td></tr>';
        // Display Solution Provider Details
        if($rows[0]->solution_provider_name != ''){
            $out .= '<tr><td><b>Solution Provider Name</b></td><td>'.$rows[0]->solution_provider_name_title.' '.$rows[0]->solution_provider_name.'</td></tr>';      
            $out .= '<tr><td><b>Solution Provider Department</b></td><td>'.$rows[0]->solution_provider_department.'</td></tr>';      
            $out .= '<tr><td><b>Solution Provider University</b></td><td>'.$rows[0]->solution_provider_university.'</td></tr>';
        }
        $out .= '</table>';
        if($rows[0]->approval_status == 3){
            if($ltype === 'Scilab')
                $out .= '<a href="http://scilab.in/lab_migration_run/'.$rows[0]->id.'"  id="rButton">Main Website</a>';
            if($ltype === 'eSim')
                $out .= '<a href="http://esim.fossee.in/lab_migration_run/'.$rows[0]->id.'"  id="rButton">Main Website</a>';
            if($ltype === 'OpenFOAM')
                $out .= '<a href="https://cfd.fossee.in/lab-migration/lab-migration-run/'.$rows[0]->id.'"  id="rButton">Main Website</a>';
        }
        $out .= '<a href="'.$Fpage.'cProfiles"  id="lButton">Back</a>';
    }
    $render_array['resume_arguments'] = array(
        '#markup' => $out,
      );
      $render_array['#attached']['library'][] = 'fossee_institute_profiles/thedata';
      return $render_array;
  }
  function getTextbook($type = '',$id = 0){
    $out = 'No Data Found';
    global $base_url;
    if($type == 'scilab') $ltype = 'Scilab';
    else if($type == 'esim') $ltype = 'eSim';
    else if($type == 'dwsim') $ltype = 'DWSIM';
    else if($type == 'openmodelica') $ltype = 'Open Modelica';
    else if($type == 'openfoam') $ltype = 'OpenFOAM';
    else $ltype = 'Others';

    $db = '';
    if($type == 'openmodelica') $db = 'OpenModelica';
    else if($type == 'or') $db = 'OR-Tools';
    else $db = $ltype;
    \Drupal\Core\Database\Database::setActiveConnection($db);
    $connection = \Drupal\Core\Database\Database::getConnection($db);
    if($ltype != 'Scilab')
        $qstr = 'SELECT * FROM textbook_companion_proposal po LEFT JOIN textbook_companion_preference pe on po.id = pe.proposal_id WHERE po.id = '.$id;
    else
        $qstr = 'SELECT * FROM textbook_companion_proposal po LEFT JOIN textbook_companion_preference pe on po.id = pe.proposal_id WHERE pe.id = '.$id;
    $query = $connection->query($qstr);
    $rows = $query->fetchAll();
    $Fpage = $base_url.'/';
    if(count($rows) > 0){
        // Display data
        $out = '<div id="text-data"><i>About The Book</i><br>';
        if(!$this->IS_EMPTY($rows[0]->book))
            $out .= '<b>Book : </b>'.$rows[0]->book.'<br>';
        $out .= '<b>Type : </b>'.$ltype.'<br>';
        if(!$this->IS_EMPTY($rows[0]->author))
            $out .= '<b>Author : </b>'.$rows[0]->author.'<br>';
        if(!$this->IS_EMPTY($rows[0]->publisher))
            $out .= '<b>Publisher : </b>'.$rows[0]->publisher.'<br>';
        if(!$this->IS_EMPTY($rows[0]->edition))
             $out .= '<b>Edition : </b>'.$rows[0]->edition.'<br>';
        if(!$this->IS_EMPTY($rows[0]->year))
            $out .= '<b>Year : </b>'.$rows[0]->year.'<br>';
        if(!$this->IS_EMPTY($rows[0]->isbn))
            $out .= '<b>ISBN : </b>'.$rows[0]->isbn.'<br>';
        $out .= '<i>Proposed By</i><br>';
        if(!$this->IS_EMPTY($rows[0]->full_name))
            $out .= '<b>Name : </b>'.$rows[0]->full_name.'<br>';
        if(!$this->IS_EMPTY($rows[0]->course))
            $out .= '<b>Course : </b>'.$rows[0]->course.'<br>';
        if(!$this->IS_EMPTY($rows[0]->branch))
            $out .= '<b>Branch : </b>'.$rows[0]->branch.'<br>';
        if(!$this->IS_EMPTY($rows[0]->university))
            $out .= '<b>University : </b>'.$rows[0]->university.'<br></div>';
    }
    // Display the main Website link
    if($rows[0]->approval_status == 1){
        if($type == 'scilab')
            $out .= '<a href="http://scilab.in/textbook_run/'.$rows[0]->id.'" target="_blank" id="rButton">Main Website</a>';
        if($type == 'esim')
            $out .= '<a href="http://esim.fossee.in/textbook_run/'.$rows[0]->id.'" target="_blank" id="rButton">Main Website</a>';
        if($ltype === 'Open Modelica')
            $out .= '<a href="https://om.fossee.in/textbook-companion/textbook-run/'.$rows[0]->id.'" target="_blank" id="rButton">Main Website</a>';
        if($ltype === 'DWSIM')
            $out .= '<a href="https://dwsim.fossee.in/textbook-companion/textbook-run/'.$rows[0]->id.'" target="_blank" id="rButton">Main Website</a>';
        if($ltype === 'OpenFOAM')
            $out .= '<a href="https://cfd.fossee.in/textbook-companion/textbook-run'.$rows[0]->id.'" target="_blank" id="rButton">Main Website</a>';
    }
    $out .= '<a href="'.$Fpage.'cProfiles"  id="lButton">Back</a>';    
    $render_array['resume_arguments'] = array(
        '#markup' => $out,
      );
      $render_array['#attached']['library'][] = 'fossee_institute_profiles/thedata';
      return $render_array;
  }
  public function getCkt($id = 0){
      global $base_url;
    $out = ''; // output HTML
    // Get circuit simulation data
    \Drupal\Core\Database\Database::setActiveConnection('eSim');
    $connection = \Drupal\Core\Database\Database::getConnection('eSim');
    $query = $connection->query('SELECT project_title,name_title,contributor_name,university,reference,approval_status FROM esim.esim_circuit_simulation_proposal WHERE id='.$id);
    $rows = $query->fetchAll();
    $Fpage = $base_url.'/';
    if(count($rows) > 0){
        if(!$this->IS_EMPTY($rows[0]->project_title))
            $out .= '<b>Title : </b>'.$rows[0]->project_title.'<br>';
        if(!$this->IS_EMPTY($rows[0]->contributor_name))
            $out .= '<b>Proposed By : </b>'.$rows[0]->name_title.' '.$rows[0]->contributor_name.'<br>';
        if(!$this->IS_EMPTY($rows[0]->university))
            $out .= '<b>University : </b>'.$rows[0]->university.'<br>';
        if(!$this->IS_EMPTY($rows[0]->reference))
            $out .= '<b>Reference : </b>'.$rows[0]->reference.'<br>';
        if($rows[0]->approval_status == 3)
            $out .= '<b>Progress : </b>Completed<br>';
        else 
            $out .= '<b>Progress : </b>In Progress<br>';
        if($rows[0]->approval_status == 3)
            $out .= '<a href="https://esim.fossee.in/circuit-simulation-project/esim-circuit-simulation-run/'.$id.'"  id="rButton">Main Website</a>';
        $out .= '<a href="'.$Fpage.'cProfiles"  id="lButton">Back</a>';
        }
    $render_array['resume_arguments'] = array(
        '#markup' => $out,
        
      );
      $render_array['#attached']['library'][] = 'fossee_institute_profiles/thedata';
      return $render_array;
  }

  // Check Wether it The string is empty , none or 0
    public function IS_EMPTY($val){
        return ($val === '' || $val === 'None' || $val === '0' || $val === null);
    }
    
}