<?php

namespace App\Controllers;

use App\Core\FilterInput;
use App\Core\Validation;
use App\Enums\MessagesType;
use App\Enums\Privilege;
use App\Helper\HandsHelper;
use App\Models\CollegeModel;
use App\Models\StudentModel;
use ErrorException;
use JetBrains\PhpStorm\NoReturn;

class StudentsController extends AbstractController
{
    use Validation;
    use HandsHelper;
    public static int $authentication = Privilege::Admin->value;
    /**
     * patterns check forms when add
     * @var array|array[]
     */
    private array $rolesAdd = [
        "NumberHoursSuccess"  => ["required", "numeric", "max" => [165]],
        "FirstName"         => ["required", "max" => [50]],
        "LastName"         => ["required", "max" => [50]],
        "Password"         => ["required"],
        "Gender"         => ["required", "max" => [6]],
        "Email"         => ["required", "email", "max" => [100]],
    ];
    private array $rolesEdit = [
        "NumberHoursSuccess"    => ["required", "numeric", "max" => [165]],
        "AdmissionYear"         => ["numeric", "between" => []],
        "StudentCollegeID"      => ["required", "numeric"],
        "FirstName"             => ["required", "required", "max" => [50]],
        "LastName"              => ["required", "required", "max" => [50]],
        "DOB"                   => ["date"],
    ];
    /**
     * #[GET('/students')]
     * @throws ErrorException
     */
    public function index(): void
    {

        $this->language->load("template.common");
        $this->language->load("students.common");
        $this->language->load("students.index");

        $extensionQuery = [
            "College" => [
                "on" => [
                    "StudentCollegeID" => CollegeModel::getPK()
                ],
            ]
        ];

        if (isset($_POST["search"])) {
            $extensionQuery["College"]["like"] = FilterInput::str($_POST["value_search"]);
        }
        $students = StudentModel::fetch(false, $extensionQuery);

        $this->authentication("students.index", [
            "students" => $students,
        ]);
    }
    /**
     * Save a StudentModel object and handle success or failure.
     *
     * This private method is used to save a StudentModel object and handle the outcome. The method takes a single parameter,
     * `$student`, which is a reference to the StudentModel object to be saved.
     *
     * The method attempts to save the `$student` object. If the save operation is successful, a success message is set
     * using the `setMessage()` method, indicating the successful operation along with the student's college name. The
     * method then redirects the user to the "/students" page.
     *
     * If the save operation fails, a failure message is set using the `setMessage()` method, indicating the failure
     * along with the student's college name.
     *
     * @param StudentModel $student A reference to the StudentModel object to be saved.
     *
     * @return void
     */
    private function saveStudent(StudentModel &$student): void
    {
        if ($student->save()) {
            $this->setMessage("success", $student->FirstName . ' ' . $student->LastName  , MessagesType::Success);
            $this->redirect("/students");
        }  else {
            $this->setMessage("fail", $student->FirstName . ' ' . $student->LastName, MessagesType::Danger);
        }
    }
    /**
     * #[GET('/students/add')]
     * @throws ErrorException
     */
    public function add(): void
    {

        $this->language->load("template.common");
        $this->language->load("students.common");
        $this->language->load("students.add");

        $colleges = CollegeModel::all();

        if (isset($_POST["add"])) {
            $errors = $this->valid($this->rolesAdd, $_POST);
            $flag = true;

            // If it forms Has Error
            if (is_array($errors)) {
                $this->addErrorsMethodToSession($errors);
                $flag = false;
            }
            if ($_POST["Password"] !== $_POST["ConfirmPassword"]) {
                $this->setMessage("error_not_match_password", '', MessagesType::Danger);
                $flag = false;
            }
            if ($flag) {
                $student = new StudentModel();

                if (! $student->ifExist("Email", $_POST["Email"])) {
                    $this->setProperties($student, $_POST);
                    $student->Password = self::encryption($_POST["Password"]);
                    $student->Privilege = Privilege::Student->value;
                    CollegeModel::increasingStudent($student->StudentCollegeID);
                    $this->saveStudent($student);

                } else {
                    $this->setMessage("already_exits", $_POST["Email"], MessagesType::Danger);
                }


            }
        }


        $this->authentication("students.add", [
            "colleges" => $colleges,
        ]);
    }

    /**
     * #[GET('/students/edit')]
     * @throws ErrorException
     */
    public function edit(): void
    {
        $this->language->load("template.common");
        $this->language->load("students.common");
        $this->language->load("students.edit");
        $student = StudentModel::getByPK($this->params[0]);
        if (! $student) {
            $this->redirect("/students");
        }
        if (isset($_POST["edit"])) {
            
            $this->rolesEdit["AdmissionYear"]["between"] = [date('Y') - 10, date("Y")];

            $errors = $this->valid($this->rolesEdit, $_POST);
            $flag = true;

            // If it forms Has Error
            if (is_array($errors)) {
                $this->addErrorsMethodToSession($errors);
                $flag = false;
            }

            if ($flag) {
                $this->setProperties($student, $_POST);
                $this->saveStudent($student);
            }
        }


        $colleges = CollegeModel::all();

        $this->authentication("students.edit", [
            "student" => $student,
            "colleges" => $colleges,
        ]);
    }
    #[NoReturn] public function delete(): void
    {
        $this->language->load("students.delete");

        $id = $this->getParams()[0];

        $student = StudentModel::getByPK($id);

        if (! $student) {
            $this->setMessage("not_exist", '', MessagesType::Danger);
        }

        $name = $student->FirstName . ' ' . $student->LastName;

        $idCollege = $student->StudentCollegeID;

        if ($student->delete()) {
            CollegeModel::decreasingStudent($idCollege);
            $this->setMessage("success", $name, MessagesType::Success);
        } else {
            $this->setMessage("fail", $name, MessagesType::Danger);
        }

        $this->redirect("/students");
    }
}