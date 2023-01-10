<?php
class Mankement extends Controller {
    private $mankementModel;
    public function __construct()
    {
        $this->mankementModel = $this->model('Mankementen');
    }
    public function index($AutoId = 2)
    {
        $result = $this->mankementModel->getMankement();
        $rows = '';

        foreach ($result as $mankement) {
            $rows .= "<tr>
           <td>$mankement->Datum</td>
           <td>$mankement->Mankement</td>
       </tr>";
        }

        $data=[ 
            'title' => "overzicht mankementen!",
            'Email' => "manhoi@gmail.com",
            'Kenteken'=> "TH-78-KL Ferrari",
            'AutoId' => $AutoId,
            'rows' => $rows
        ];
        $this->view('mankement/index', $data);
    }
    public function addMankement($AutoId = NUll)
    {
        $data = [
            'title' => 'invoeren mankement',
            'Kenteken' => "TH-78-KL Ferari" ,
            'AutoId' => $AutoId,
            'MankementError' => ''
        ];
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
           $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
           $data = [ 
                'title' => 'invoeren mankement',
                'Kenteken' => "TH-78-KL Ferari" ,
                'AutoId' => $_POST['AutoId'],
                'Mankement' => $_POST['Mankement'],
                'MankementError' => ''
           ];
           $data = $this->validateAddMankementForm($data);
           if (empty($data['MankementError'])) {
            $result = $this->mankementModel->addMankement($_POST);

            if ($result) {
                $data['title'] = "<p>U heeft een nieuwe mankement succesvol toegevoegd!</p>";
            } else {
                echo "<p>Het is mislukt om een mankement toe tevoegen!</p>";
            }
            header('Refresh:2 url=' . URLROOT . '/mankement/index');
        } else {
            header('Refresh:2 url=' . URLROOT . '/mankement/addmankement/' . $data['AutoId']);
        }
        }
        $this->view('mankement/addmankement', $data);
    }

    private function validateAddMankementForm($data)
    {
        if (strlen($data['Mankement']) > 50) {
            $data['MankementError'] = "Het mankement is langer dan 50 teken prober op niuw!!";
        } elseif (empty($data['Mankement']))
        {
             $data['MankementError'] = "U bent verplicht om een mankement in te invullen!";
        }

        return $data;
    }
}