<?php
class Countries extends Controller
{
    private $countryModel;
    public function __construct()
    {
       $this->countryModel =  $this->model('Country');
    }

    public function index($land = null , $age = null)
    {
       $records = $this->countryModel->getCountries();

       
       $rows = '';
       foreach($records as $value)
       {
          $rows .= "<tr>
                      <td>$value->Name</td>
                      <td>$value->CapitalCity</td>
                      <td>$value->Continent</td>
                      <td>$value->Population</td>
                      <td><a href='" . URLROOT . "/countries/update/$value->Id'>update</a></td>
                      <td><a href='" . URLROOT . "/countries/delete/$value->Id'>delete</a></td>
                    </tr>";
       }
       $data = [
          'title' => "Landen van de wereld",
          'rows' => $rows
       ];
       $this->view('countries/index', $data);
    }

    public function update($id = null)
    {
       

       if ($_SERVER["REQUEST_METHOD"] == "POST")
       {
          $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
          $this->countryModel->updateCountry($_POST);
          header("Location: " . URLROOT . "/countries/index");
       } else{
         $row = $this->countryModel->getSingleCountry($id);
       $data = [
          'title' => '<h1>Update landenoverzicht</h1>',
          'row' => $row
       ];
       $this->view("countries/update", $data);
       }
       
       
    }

    public function delete($id) {
       

       $this->countryModel->deleteCountry($id);

       $data = [
          'deleteStatus' => "Het record met id = $id is verwijdert"
       ];
       $this->view("countries/delete", $data);
       header("Refresh:2; url=" . URLROOT . "/countries/index");
    }

    public function create() {
       if ($_SERVER["REQUEST_METHOD"] == "POST") {
          
          $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

          $this->countryModel->createCountry($_POST);

          header("Location:" . URLROOT . "/countries/index");
       } else{
          
       $data = [
         'title' => "Voeg een nieuw land in"
       ];

       $this->view("countries/create", $data);
      }
    }
}