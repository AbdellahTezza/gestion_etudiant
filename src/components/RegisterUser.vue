<template>
    <div>
        <h1 class="text-center">CRUD PHP, VUE.JS 3 & MYSQL <span>By abdellah</span> </h1>
    </div>
    <div class="container" v-if="!isDBConneted">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ connection_msg }}
        </div>
    </div>
    <div class="container" v-else>
        <!-- Show Add Student Button -->
        <div class="container">
            <div class="col-lg-12">
                <button class="float-end btn btn-info" @click="addModalDialog(true)">
                    Add New Student
                </button>
                <button class="float-start btn btn-danger" v-if="studentData.length > 0" @click="DeleteAllstudent(true)">
                    Delete all Students
                </button>
                <div class="clearfix"></div>
            </div>
            <hr class="bg-info" />
        </div>
        <!-- Show Error Message -->
        <!-- Show Success Message -->
        <div class="alert alert-danger alert-dismissible fade show" role="alert" v-if="dangerMsg">
            A simple danger alert—check it out!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <div class="alert alert-success alert-dismissible fade show" role="alert" v-if="successMsg">
            {{ successMsg }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <!-- Show Students Details : Tables  -->
        <table class="table table-border table-striped caption-top">
            <caption> List of Registered Students ({{ studentData.length }})</caption>
            <thead>
                <tr class="bg-success text-light text-center">
                    <th> ID </th>
                    <th> Name </th>
                    <th> Email </th>
                    <th> Phone </th>
                    <th> Actions </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(stundent, i) in studentData" :key="1">
                    <td>{{ stundent.id }} </td>
                    <td> {{ stundent.name }} </td>
                    <td>{{ stundent.email }} </td>
                    <td> {{ stundent.phone }} </td>
                    <td> <button class="btn btn-danger"
                            @click="deleteModalDialog(true); selectStudent(stundent)">Delete</button> <button
                            class="btn btn-warning" @click="editModalDialog(true); selectStudent(stundent)">Update</button>
                    </td>
                </tr>
            </tbody>
        </table>
        <!-- Show Add New Student Model  -->

        <div id="overlay" v-if="showAddModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-info">Add New User</h5>
                        <button aria-hidden="true" @click="addModalDialog(false)">
                            ferme
                        </button>
                    </div>
                    <div class="modal-body p-4">
                        <form action="#" method="post" @click.prevent>
                            <div class="form-floating mb-3" :class="{ 'form-group-error': v$.newStudent.name.$error }">
                                <input type="text" class="form-control" id="studentNameFloat" placeholder="Jonh Doe"
                                    v-model="newStudent.name" />
                                <label for="studentNameFloat">Student Name</label>
                                <span class="error-feedback" v-if="v$.newStudent.name.$error">
                                    {{ v$.newStudent.name.$errors[0].$message }}
                                </span>
                            </div>
                            <div class="form-floating mb-3" :class="{ 'form-group-error': v$.newStudent.name.$error }">
                                <input type="text" class="form-control" id="studentEmailFloat" placeholder="Jonh Doe"
                                    v-model="newStudent.email" />
                                <label for="studentNameFloat">Student Email</label>
                                <span class="error-feedback" v-if="v$.newStudent.email.$error">
                                    {{ v$.newStudent.email.$errors[0].$message }}
                                </span>
                            </div>
                            <div class="form-floating mb-3" :class="{ 'form-group-error': v$.newStudent.name.$error }">
                                <input type="text" class="form-control" id="studentPhoneFloat" placeholder="Jonh Doe"
                                    v-model="newStudent.phone" />
                                <label for="studentNameFloat">Student Phone</label>
                                <span class="error-feedback" v-if="v$.newStudent.phone.$error">
                                    {{ v$.newStudent.phone.$errors[0].$message }}
                                </span>
                            </div>
                            <hr class="bg-info" />
                            <div class="d-grid gap-2">
                                <button class="btn btn-info" @click="addNewUser()">Add New User</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Show Edit Student Modal  -->
        <div id="overlay" v-if="editAddModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-info">Edit User</h5>
                        <button aria-hidden="true" @click="editModalDialog(false)">
                            ferme
                        </button>
                    </div>
                    <div class="modal-body p-4">
                        <form action="#" method="post" @click.prevent>
                            <div class="form-floating mb-3" :class="{ 'form-group-error': v$.currentStudent.name.$error }">
                                <input type="text" class="form-control" id="studentNameFloat" placeholder="Jonh Doe"
                                    v-model="currentStudent.name" />
                                <label for="studentNameFloat">Student Name</label>
                                <span class="error-feedback" v-if="v$.currentStudent.name.$error">
                                    {{ v$.currentStudent.name.$errors[0].$message }}
                                </span>
                            </div>
                            <div class="form-floating mb-3" :class="{ 'form-group-error': v$.currentStudent.name.$error }">
                                <input type="text" class="form-control" id="studentEmailFloat" placeholder="Jonh Doe"
                                    v-model="currentStudent.email" />
                                <label for="studentNameFloat">Student Email</label>
                                <span class="error-feedback" v-if="v$.currentStudent.email.$error">
                                    {{ v$.currentStudent.email.$errors[0].$message }}
                                </span>
                            </div>
                            <div class="form-floating mb-3" :class="{ 'form-group-error': v$.currentStudent.name.$error }">
                                <input type="text" class="form-control" id="studentPhoneFloat" placeholder="Jonh Doe"
                                    v-model="currentStudent.phone" />
                                <label for="studentNameFloat">Student Phone</label>
                                <span class="error-feedback" v-if="v$.currentStudent.phone.$error">
                                    {{ v$.currentStudent.phone.$errors[0].$message }}
                                </span>
                            </div>
                            <hr class="bg-info" />
                            <div class="d-grid gap-2">
                                <button class="btn btn-info" @click="editUser()">Edit User</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Show Delete  Student Modal  -->
        <div id="overlay" v-if="deleteModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-info">Delete Student</h5>
                        <button aria-hidden="true" @click="deleteModalDialog(false)">
                            ferme
                        </button>
                    </div>
                    <div class="modal-body p-4">
                        <form action="#" method="post" @click.prevent>
                            <h6>Are you sure you want to delete this student ?</h6>
                            <p>{{ currentStudent.name }}</p>
                            <p>{{ currentStudent.email }}</p>
                            <p>{{ currentStudent.phone }}</p>
                            <hr class="bg-info" />
                            <div class="d-grid gap-2">
                                <button class="btn btn-info" @click="deleteUser()">Delete Current Student</button>
                                <button class="btn btn-info" @click="deleteModalDialog(false)">No, don't Delete</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Show Deleye All Students Modal  -->
        <!-- Delete All  Student   -->
        <div id="overlay" v-if="alldelete">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-info">Delete All Student</h5>
                        <button aria-hidden="true" @click="DeleteAllstudent(false)">
                            ferme
                        </button>
                    </div>
                    <div class="modal-body p-4">
                        <form action="#" method="post" @click.prevent>
                            <h6>Are you sure you want to delete All student ?</h6>
                            <hr class="bg-info" />
                            <div class="d-grid gap-2">
                                <button class="btn btn-info" @click="deleteModelAll()">Delete Current ALL Student </button>
                                <button class="btn btn-info" @click="deleteModalDialog(false)">No, don't Delete</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Show Deleye All Students Modal  -->
    </div>
</template>
<script>
import axios from "axios";
import useVuelidate from '@vuelidate/core';
import { required, email, minLength } from '@vuelidate/validators';

export default {
    name: 'RegisterUser',
    data() {
        return {
            v$: useVuelidate(),
            errMsg: '',
            successMsg: '',
            dangerMsg: '',
            studentData: [],
            showAddModal: false,
            editAddModal: false,
            deleteModal: false,
            alldelete: false,
            //object
            newStudent: {
                name: "",
                email: "",
                phone: "",
            },
            currentStudent: {},
            isDBConneted: "",
            connection_msg: ""
        };
    },
    validations() {
        return {
            newStudent: {
                name: { required, minLength: minLength(5) },
                email: { required, email },
                phone: { required, minLength: minLength(10) },
            },
            currentStudent: {
                name: { required, minLength: minLength(5) },
                email: { required, email },
                phone: { required, minLength: minLength(10) },
            },
        }
    },
    mounted() {
        this.getStudentsData();
        this.dbConnection();
    },
    methods: {
        addModalDialog(val) {
            this.showAddModal = val;
        },
        editModalDialog(val) {
            this.editAddModal = val;
        },
        deleteModalDialog(val) {
            this.deleteModal = val;
            this.toFormData(this.currentStudent);
        },
        DeleteAllstudent(val) {
            this.alldelete = val;
        },
        async addNewUser() {
            this.v$.newStudent.$validate();
            // console.log();
            if (!this.v$.newStudent.$error) {
                this.editModalDialog(false);
                this.clearOldmessage;
                console.log("Validated Sucessfully");
                var formData = this.toFormData(this.newStudent);
                let res = await axios.post(
                    `http://localhost/project_vuejs/tutophpvuejs/src/api/students.php?action=add`,
                    formData
                );
            const restaData = res.data;
            if (res.status == 200) {
                if (restaData.error) {
                    this.errMsg = "Erreur";
                } else {
                    this.newStudent = {name:"", email:"", phone: ""};
                    // this.getStudentsData();
                    this.studentData = restaData.students;
                    this.v$.newStudent.$reset();
                }
            } else {
                console.log("Not validated");
            }
        }
        },
       async editUser() {
            this.v$.currentStudent.$validate()
            // console.log();
            if (!this.v$.currentStudent.$error) {
                this.editModalDialog(false);
                this.clearOldmessage;
                console.log("Validated Sucessfully");
                var formData = this.toFormData(this.currentStudent);
                let res = await axios.post(
                    `http://localhost/project_vuejs/tutophpvuejs/src/api/students.php?action=update`,
                    formData
                );
            const restaData = res.data;
            if (res.status == 200) {
                if (restaData.error) {
                    this.errMsg = "Erreur";
                } else {

                    this.currentStudent = {};
                    // this.getStudentsData();
                    this.studentData = restaData.students;
                    this.v$.currentStudent.$reset();
                }
            }
            } else {
                console.log("Not validated");
            }

        },
        selectStudent(std) {
            this.currentStudent = std;
        },
        // deleteModalline() {
        //     console.log("delete");
        // },
        async deleteModelAll() {
            this.successMsg = "Susssuf all delete";
            this.clearOldmessage;
            this.deleteModal = false;
            this.toFormData(this.currentStudent);
            let res = await axios.post("http://localhost/project_vuejs/tutophpvuejs/src/api/students.php?action=deleteAll");
            const restaData = res.data;
            if (res.status == 200) {
                this.studentData = restaData.students;
                if (restaData.error) {
                    this.errMsg = "Erreur";
                } else {
                    this.studentData = "";
                }

            }
        },
        async deleteUser() {
            this.toFormData(this.currentStudent);
            this.clearOldmessage;
            this.deleteModal = false;
            var formData = this.toFormData(this.currentStudent);
            let res = await axios.post(
                `http://localhost/project_vuejs/tutophpvuejs/src/api/students.php?action=delete`,
                formData
            );
            const restaData = res.data;
            if (res.status == 200) {
                if (restaData.error) {
                    this.errMsg = "Erreur";
                } else {
                    let newStudentsDAta = this.studentData.filter((ele) => ele.id != this.currentStudent.id);
                    console.table(newStudentsDAta);
                    this.currentStudent = {};
                    this.getStudentsData();
                    this.studentData = newStudentsDAta;
                }

            }
        },
        clearOldmessage() {
            this.errMsg = "";
            this.studentData = "";
        },
        async getStudentsData() {
            let res = await axios.get("http://localhost/project_vuejs/tutophpvuejs/src/api/students.php?action=read");
            const restaData = res.data;
            console.log(res.status);
            if (res.status == 200) {
                this.studentData = restaData.students;
                if (restaData.error) {
                    this.errMsg = "Erreur";
                } else {
                    this.studentData = restaData.students;
                }

            }
        },
        async dbConnection() {
            let res = await axios.get("http://localhost/project_vuejs/tutophpvuejs/src/api/students.php");
            const restaData = res.data;
            this.isDBConneted = restaData.is_db_connected;
            this.connection_msg = restaData.connection_msg;
        },
        toFormData(obj) {
            var fd = new FormData();
            for (var i in obj) {
                console.log(i + " => " + obj[i]);
                fd.append(i, obj[i]);
            }
            return fd;
        }
    }
}
</script>
<style scoped>
h1 {
    background-color: cadetblue;
    color: white;
    padding: 8px;
    margin-top: 0px;
    margin-bottom: 50px;
}

#overlay {
    border: 1px solid #ccc;
    padding: 20px;
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    background-color: rgb(0 0 0 /47%);
}

.modal-dialog {
    max-width: 500px;
    margin: 1.75rem auto;
}

.modal-dialog {
    position: relative;
    width: auto;
    pointer-events: none;
    background: #fdfaff;
    padding: 23px;
}

.form-group-error {
    color: red;
}

.form-group-error input {
    border-color: red;
}

span.error-feedback {
    display: block;
    padding: 11px 0;
    font-size: 18px;
    text-align: left;
    color: red;
}</style>