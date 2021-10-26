<script src="https://unpkg.com/vue/dist/vue.js"></script>
<script src="https://unpkg.com/vue-router/dist/vue-router.js"></script>
<template>
  <main class="main" style="padding-top: 55px">
    <!-- Breadcrumb -->
    <div class="container-fluid">
      <!-- Tabla Listado  de empleados-->
      <div class="card">
        <div class="card-header">
          <i class="fa fa-align-justify"></i> Empleados
          <button
            type="button"
            @click="openModal('employes', 'create')"
            class="btn btn-secondary"
          >
            <i class="icon-plus"></i>&nbsp;Nuevo
          </button>
        </div>
        <div class="card-body">
          <div style="overflow-x: auto; min-width: 80%">
            <table class="table table-bordered table-striped table-sm">
              <thead>
                <tr>
                  <th>Opciones</th>
                  <th>A. Paterno</th>
                  <th>A. Materno</th>
                  <th>Nombre</th>
                  <th>Email</th>
                  <th>Codigo</th>
                  <th>Tipo de contrato</th>
                  <th>Activo</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="employe in arrayEmployes" :key="employe.id">
                  <td>
                    <button
                      type="button"
                      @click="openModal('employes', 'update', employe)"
                      class="btn btn-warning btn-sm"
                    >
                      <i class="fe-pencil">Editar</i>
                    </button>
                    &nbsp;
                    <button
                      type="button"
                      class="btn btn-danger btn-sm"
                      @click="deleteEmploye(employe.id)"
                    >
                      <i class="icon-trash">Eliminar</i></button
                    >&nbsp;
                    <template v-if="employe.active">
                      <button
                        type="button"
                        class="btn btn-secondary btn-sm"
                        @click="disableEmploye(employe.id)"
                      >
                        <i class="icon-close">Desactivar</i>
                      </button>
                    </template>
                    <template v-else>
                      <button
                        type="button"
                        class="btn btn-info btn-sm"
                        @click="enableEmploye(employe.id)"
                      >
                        <i class="icon-check">Activar</i>
                      </button>
                    </template>
                    <button
                      type="button"
                      @click="openModal('employes', 'details', employe)"
                      class="btn btn-success btn-sm"
                    >
                      <i class="icon-eye">Detalles</i>
                    </button>
                    &nbsp;
                  </td>
                  <td v-text="employe.first_last_name"></td>
                  <td v-text="employe.second_lastname"></td>
                  <td v-text="employe.name"></td>
                  <td v-text="employe.email"></td>
                  <td v-text="employe.code"></td>
                  <td v-text="employe.contract_type"></td>
                  <td>
                    <div v-if="employe.active">
                      <span class="badge badge-success">Activo</span>
                    </div>
                    <div v-else>
                      <span class="badge badge-danger">Desactivado</span>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <!-- Fin ejemplo de tabla Listado -->
    </div>
    <!--Inicio del modal agregar/actualizar-->
    <template v-if="actionType == 1 || actionType == 2">
      <div
        class="modal fade"
        tabindex="-1"
        :class="{ mostrar: modal }"
        role="dialog"
        aria-labelledby="myModalLabel"
        style="display: none"
        aria-hidden="true"
      >
        <div
          class="modal-dialog modal-primary modal-lg"
          style="padding-top: 55px"
          role="document"
        >
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" v-text="modalTitle"></h4>
              <button
                type="button"
                class="close"
                @click="closeModal()"
                aria-label="Close"
              >
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <form enctype="multipart/form-data" class="form-horizontal">
                <div style="overflow-x: auto; overflow-y: auto; min-width: 80%">
                  <div class="form-group">
                    <label for="inputEmail">Email address</label>
                    <input
                      type="email"
                      class="form-control"
                      id="inputEmail"
                      aria-describedby="emailHelp"
                      placeholder="Enter email"
                      v-model="email"
                    />
                    <small
                      v-if="submitted && errors.email"
                      class="text-danger font-14"
                      >{{ errors.email }}</small
                    >
                  </div>
                  <div class="form-group">
                    <label for="inputName">Nombre</label>
                    <input
                      type="text"
                      class="form-control"
                      id="inputName"
                      aria-describedby="textHelp"
                      placeholder="Ingrese nombre"
                      v-model="name"
                    />
                     <small
                      v-if="submitted && errors.name"
                      class="text-danger font-14"
                      >{{ errors.name }}</small
                    >
                  </div>
                  <div class="form-group">
                    <label for="inputcode">Codigo</label>
                    <input
                      type="text"
                      class="form-control"
                      id="inputcode"
                      aria-describedby="textHelp"
                      placeholder="Ingrese su codigo"
                      v-model="code"
                    />
                    <small
                      v-if="submitted && errors.code"
                      class="text-danger font-14"
                      >{{ errors.code }}</small
                    >
                  </div>
                  <div class="form-group">
                    <label for="inputFirstLastName">Primer apellido</label>
                    <input
                      type="text"
                      class="form-control"
                      id="inputFirstLastName"
                      aria-describedby="textHelp"
                      placeholder="Ingrese primer apellido"
                      v-model="first_last_name"
                    />
                   <small
                      v-if="submitted && errors.first_last_name"
                      class="text-danger font-14"
                      >{{ errors.first_last_name }}</small
                    >
                  </div>
                  <div class="form-group">
                    <label for="inputSecondLastName">Segundo paellido</label>
                    <input
                      type="text"
                      class="form-control"
                      id="inputSecondLastName"
                      aria-describedby="textHelp"
                      placeholder="Ingrese segundo apellido"
                      v-model="second_lastname"
                    />
                    <small
                      v-if="submitted && errors.second_lastname"
                      class="text-danger font-14"
                      >{{ errors.second_lastname }}</small
                    >
                  </div>
                  <div class="form-check">
                    <input
                      type="checkbox"
                      class="form-check-input"
                      id="statusCheck"
                      v-model="active"
                    />
                    <label class="form-check-label" for="statusCheck"
                      >Activo /Inactivo</label
                    >
                    <small id="textHelp" class="form-text text-muted"
                      >Estado actual</small
                    >
                  </div>

                  <div class="form-group">
                    <label for="inputContractType">Tipo de contrato</label>
                    <input
                      type="text"
                      class="form-control"
                      id="inputContractType"
                      aria-describedby="textHelp"
                      placeholder="Ingrese su tipo de contrato"
                      v-model="contract_type"
                    />
                   <small
                      v-if="submitted && errors.contract_type"
                      class="text-danger font-14"
                      >{{ errors.contract_type }}</small
                    >
                  </div>
                </div>
              </form>
            </div>
            <div class="modal-footer">
              <button
                v-if="actionType == 1"
                type="button"
                class="btn btn-primary"
                v-on:click="createEmploye()"
              >
                Guardar
              </button>
              <button
                v-if="actionType == 2"
                type="button"
                class="btn btn-primary"
                v-on:click="updateEmploye()"
              >
                actualizar
              </button>
              <button
                type="button"
                v-if="actionType == 1"
                class="btn btn-secondary"
                @click="closeModal()"
              >
                Cerrar
              </button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
    </template>
    <!--Modal ver detalles-->
    <template v-else-if="actionType == 3">
      <div
        class="modal fade"
        tabindex="-1"
        :class="{ mostrar: modal }"
        role="dialog"
        aria-labelledby="myModalLabel"
        style="display: none"
        aria-hidden="true"
      >
        <div class="modal-dialog modal-primary modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" v-text="modalTitle"></h4>
              <button
                type="button"
                class="close"
                @click="closeModal()"
                aria-label="Close"
              >
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <form enctype="multipart/form-data" class="form-horizontal">
                <div style="overflow-x: auto; min-width: 80%">
                  <table class="table table-bordered table-striped table-sm">
                    <thead></thead>
                    <tbody>
                      <tr></tr>
                      <tr>
                        <th>A. Paterno</th>
                        <td>
                          <input
                            type="text"
                            v-model="first_last_name"
                            class="form-control"
                            readonly
                          />
                        </td>
                      </tr>
                      <tr></tr>
                      <tr>
                        <th>A. Materno</th>
                        <td>
                          <input
                            type="text"
                            v-model="second_lastname"
                            class="form-control"
                            readonly
                          />
                        </td>
                      </tr>
                      <tr>
                        <th>Nombre</th>
                        <td>
                          <input
                            type="text"
                            v-model="name"
                            class="form-control"
                            readonly
                          />
                        </td>
                      </tr>
                      <tr>
                        <th>Código</th>
                        <td>
                          <input
                            type="text"
                            v-model="code"
                            class="form-control"
                            readonly
                          />
                        </td>
                      </tr>
                      <tr>
                        <th>Email</th>
                        <td>
                          <input
                            type="text"
                            v-model="email"
                            class="form-control"
                            readonly
                          />
                        </td>
                      </tr>
                      <tr>
                        <th>Tipo de contrato</th>
                        <td>
                          <input
                            type="text"
                            v-model="contract_type"
                            class="form-control"
                            readonly
                          />
                        </td>
                      </tr>
                      <tr>
                        <th>Estado</th>
                        <td>
                          <div v-if="active">
                            <span class="badge badge-success">Activo</span>
                          </div>
                          <div v-else>
                            <span class="badge badge-danger">Desactivado</span>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </form>
            </div>

            <div class="modal-footer">
              <button
                v-if="actionType == 1"
                type="button"
                class="btn btn-primary"
                v-on:click="createEmploye()"
              >
                Guardar
              </button>
              <button
                v-if="actionType == 2"
                type="button"
                class="btn btn-primary"
                v-on:click="updateEmploye()"
              >
                actualizar
              </button>
              <button
                type="button"
                v-if="actionType == 1"
                class="btn btn-secondary"
                @click="closeModal()"
              >
                Cerrar
              </button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
    </template>
    <!--Fin del modal-->
  </main>
</template>

<script>
export default {
  data() {
    return {
      id               : "",
      name             : "",
      first_last_name  : "",
      second_lastname  : "",
      email            : "",
      contract_type    : "",
      active           : "",
      code             : "",
      modal            : 0,
      modalTitle       : "",
      actionType       : 0,
      arrayEmployes    : [],
      submitted        : false,
      errors           : {},
    };
  },

  mounted() {
    this.listEmployes();
  },
  methods: {
    listEmployes() {
      let me = this;
      axios
        .get("/employes")
        .then(function (response) {
          console.log({ employes: response.data });
          me.arrayEmployes = response.data;
        })
        .catch(function (error) {
          console.table(error);
        });
    },
    createEmploye() {
      this.submitted = true;
      this.errors = {};
      this.valideForm();
      console.log(Object.keys(this.errors));

    if (Object.keys(this.errors).length) {
        return;
    }

    let me = this;
    axios
    .post("/employes", {
        name: this.name,
        first_last_name: this.first_last_name,
        second_lastname: this.second_lastname,
        email: this.email,
        contract_type: this.contract_type,
        code: this.code,
        active: this.active,
    })
    .then(function (response) {
        me.closeModal();
        me.listEmployes();
    })
    .catch(function (error) {
    Swal.fire({
            icon: 'error',
            title: 'Lo sentimos...',
            text: 'Los datos enviados no son validos!'
        });
        console.table(error);
    });
    },
    updateEmploye() {
      this.submitted = true;
      this.errors = {};
      this.valideForm();

        console.log(Object.keys(this.errors));
      if (Object.keys(this.errors).length) {
            return;
        }
      let me = this;
      axios
        .put("/employes", {
          name: this.name,
          first_last_name: this.first_last_name,
          second_lastname: this.second_lastname,
          email: this.email,
          contract_type: this.contract_type,
          code: this.code,
          active: this.active,
          id: this.id,
        })
        .then(function (response) {
          me.closeModal();
          me.listEmployes();
        })
        .catch(function (error) {
          console.table(error);
        });
    },
    disableEmploye(id) {
      swal({
        title: "Esta seguro de desactivar este empleado",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Aceptar!",
        cancelButtonText: "Cancelar",
        confirmButtonClass: "btn btn-success",
        cancelButtonClass: "btn btn-danger",
        buttonsStyling: false,
        reverseButtons: true,
      }).then((result) => {
        if (result == true) {
          let me = this;
          axios
            .patch("/employes/disable", {
              id: id,
            })
            .then(function (response) {
              me.listEmployes();
              swal("Desactivado!", "Registro desactivado con éxito", "success");
            })
            .catch(function (error) {
              me.listEmployes();
              console.table(error);
            });
        } else if (
          // Read more about handling dismissals
          result.dismiss === swal.DismissReason.cancel
        ) {
        }
      });
    },
    enableEmploye(id) {
      swal({
        //mostrar alesta de confirmacion son sweet alers
        title: "Esta seguro de activar este empleado?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Aceptar!",
        cancelButtonText: "Cancelar",
        confirmButtonClass: "btn btn-success",
        cancelButtonClass: "btn btn-danger",
        buttonsStyling: false,
        reverseButtons: true,
      }).then((result) => {
        console.log(result);
        if (result == true) {
          let me = this;
          axios
            .patch("/employes/enable", {
              id: id,
            })
            .then(function (response) {
              me.listEmployes();
              swal(
                "Activado!",
                "El registro ha sido activado con éxito.",
                "success"
              );
            })
            .catch(function (error) {
              console.log(error);
            });
        } else if (result.dismiss === swal.DismissReason.cancel) {
        }
      });
    },

    deleteEmploye(id) {
      swal({
        //mostrar alesta de confirmacion son sweet alers
        title: "Esta seguro de eliminar definitivamente este empleado?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Aceptar!",
        cancelButtonText: "Cancelar",
        confirmButtonClass: "btn btn-success",
        cancelButtonClass: "btn btn-danger",
        buttonsStyling: false,
        reverseButtons: true,
      }).then((result) => {
        if (result == true) {
          let me = this;
          axios
            .put("/employes/delete", {
              id: id,
            })
            .then(function (response) {
              me.listEmployes();
              swal(
                "Eliminado!",
                "El registro ha sido eliminado con éxito.",
                "success"
              );
            })
            .catch(function (error) {
              console.log(error);
            });
        } else if (result.dismiss === swal.DismissReason.cancel) {
        }
      });
    },

    closeModal() {
      //Cerrar modals
      this.modal = 0;
      this.name = "",
      this.first_last_name = "",
      this.second_lastname = "",
      this.email = "",
      this.contract_type = "",
      this.code = "",
      this.active = false;

      this.submitted = false;
      this.errors = {};
      this.listEmployes();
    },

    valideForm() {
      if (!this.code) {
        this.errors.code = "El código es un campo requerido";
      }

      if (!this.name) {
        this.errors.name = "El nombre es un campo requerido";
      }
      this.validateField('name');

      if (!this.first_last_name) {
        this.errors.first_last_name = "El apellido paterno es un campo requerido";
      }
      this.validateField("first_last_name");

      if (!this.second_lastname) {
        this.errors.second_lastname = "El apellido materno es un campo requerido";
      }
      this.validateField("second_lastname");

      if (!this.email) {
        this.errors.email = "El correo electrónico es un campo requerido";
      }
      this.validateField("email");

      if (!this.contract_type) {
        this.errors.contract_type = "El tipo de contrato es un campo requerido";
      }
    },
    validateField(field) {
      if (field === "email") {
        if (
          !/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(
            this.email
          )
        ) {
          this.errors.email = "Please enter a valid email address";
        }
        return;
      }

      if (!/^[A-Za-z\u00C0-\u00FF\-\_]*$/i.test(this.field)) {
        this.errors[field] = `El campo ${field} solo admite letras y guiones`;
      }
    },
    openModal(model, action, data = []) {
      switch (model) {
        case "employes": {
          switch (action) {
            case "create": {
              this.modal = 1;
              this.modalTitle = "Registrar empleado";
              (this.name = ""),
                (this.first_last_name = ""),
                (this.second_lastname = ""),
                (this.email = ""),
                (this.contract_type = ""),
                (this.code = ""),
                (this.active = false);
              this.actionType = 1;
              break;
            }
            case "update": {
              this.modal = 2;
              this.modalTitle = "Actualizar empleado";
              (this.name = data.name),
                (this.first_last_name = data.first_last_name),
                (this.second_lastname = data.second_lastname),
                (this.email = data.email),
                (this.contract_type = data.contract_type),
                (this.code = data.code),
                (this.active = data.active);
              this.id = data.id;
              this.actionType = 2;
              break;
            }
            case "details": {
              this.modal = 3;
              this.modalTitle = "Detalles";
              (this.name = data.name),
                (this.first_last_name = data.first_last_name),
                (this.second_lastname = data.second_lastname),
                (this.email = data.email),
                (this.contract_type = data.contract_type),
                (this.code = data.code),
                (this.active = data.active);
              this.actionType = 3;
              break;
            }
          }
        }
      }
    },
  },
};
</script>
<style>
.modal-content {
  width: 100% !important;
  position: absolute !important;
}
.mostrar {
  display: list-item !important;
  opacity: 1 !important;
  position: absolute !important;
  background-color: #3c29297a !important;
}
.div-error {
  display: flex;
  justify-content: center;
}
.text-error {
  color: red !important;
  font-weight: bold;
}
</style>
