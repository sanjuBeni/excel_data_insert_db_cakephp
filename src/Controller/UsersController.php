<?php

namespace App\Controller;

use Cake\Routing\Router;

error_reporting(0);
include('../vendor/elton182/spreadsheet/php-excel-reader/excel_reader2.php');
include('../vendor/elton182/spreadsheet/SpreadsheetReader.php');



//use elton182\spreadsheet\SpreadsheetReader;

class UsersController extends AppController
{
    private $table;
    public $url;

    public function initialize(): void
    {
        parent::initialize();
        $this->url = Router::url("/", true);
        $this->table = $this->getTableLocator()->get('Assets');
    }

    public function userData()
    {

        if ($this->request->is('post')) {
            $file = $this->request->getData('file');

            $fileTmpName = $file->getStream()->getMetadata('uri');
            $fileName = $file->getClientFilename();
            // echo $fileName;
            // die;

            $Reader = new \SpreadsheetReader($fileTmpName, $fileName);
            foreach ($Reader as $Row) {
                $user = $this->Users->newEmptyEntity();
                print_r($Row);

                $user->name  = $Row[0];
                $user->email  = $Row[1];
                $user->phone  = $Row[2];
                $this->Users->save($user);
            }
        }
    }

    public function assetsData()
    {

        if ($this->request->is('post')) {
            $file = $this->request->getData('file');

            $fileTmpName = $file->getStream()->getMetadata('uri');
            // echo $fileTmpName;
            $fileName = $file->getClientFilename();
            // echo $fileName;

            $render = new \SpreadsheetReader($fileTmpName, $fileName);

            foreach ($render as $row) {
                $user = $this->table->newEmptyEntity();
                // echo "<pre>";
                // print_r($row);

                $user->asset_name = $row[0];

                $user->asset_title = $row[1];

                $user->asset_type = $row[2];

                $user->amount = $row[3];

                $user->date_of_valuation = $row[4];

                $user->risk_level = $row[5];

                $user->time_horizon = $row[6];

                $user->include = $row[7];

                $user->annual_growth_rate = $row[8];

                $user->cash_flow_amount = $row[9];

                $user->beneficiaries = $row[10];

                $this->table->save($user);
            }
        }
    }

    public function dataVisualized()
    {
        // echo "<pre>";
        // print_r($this->table->find()->toList());
        $tblData = $this->table->find()->toArray();
        $url = $this->url . "users/dataVisualized";
        $this->set(compact('tblData', '$url'));
        // print_r($tblData);
        // die;
    }

    public function pieChart()
    {
        $tblData = $this->table->find()->toArray();
        $this->set(compact('tblData'));
    }
}
