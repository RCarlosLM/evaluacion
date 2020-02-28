<template>
	<div>

		<div class="row mt-3">

			<div class="col-md-4">
        <div class="card border-info">
					<div class="card-header bg-light">
						<h4>
							Prospectos
						</h4>
					</div>
          <div class="card-body">
            <div class="row">
							<div class="col-md-12">
								<label for="nombre" class="font-weight-bold">
									Nombre
								  	<small v-if="data_errors.nombre" class="form-text error-input p-1 alert-danger fade show">
								    	{{ data_errors.nombre[0] }}
								  	</small>
								</label>
								<div class="input-group">
									<input
										v-model="prospectos.nombre"
										placeholder="Nombre"
										class="form-control"
										type="text">
									</input>
								</div> 
							</div>
							<div class="col-md-6 mt-1">
								<label for="apellido_paterno" class="font-weight-bold">
									Apellido Paterno
									<small v-if="data_errors.apellido_paterno" class="form-text error-input p-1 alert-danger fade show">
										{{ data_errors.apellido_paterno[0] }}
									</small>
								</label>
								<div class="input-group">
									<input
										v-model="prospectos.apellido_paterno"
										placeholder="Apellido paterno"
										class="form-control"
										type="text">
									</input>
								</div> 
							</div>
							<div class="col-md-6 mt-1">
								<label for="apellido_materno" class="font-weight-bold">
									Apellido Materno
									<small v-if="data_errors.apellido_materno" class="form-text error-input p-1 alert-danger fade show">
										{{ data_errors.apellido_materno[0] }}
									</small>
								</label>
								<div class="input-group">
									<input
										v-model="prospectos.apellido_materno"
										placeholder="Apellido materno"
										class="form-control"
										type="text">
									</input>
								</div> 
							</div>
							<div class="col-md-6 mt-1">
								<label for="celular" class="font-weight-bold">
									Celular
									<small v-if="data_errors.celular" class="form-text error-input p-1 alert-danger fade show">
										{{ data_errors.celular[0] }}
									</small>
								</label>
								<div class="input-group">
									<input
										v-model="prospectos.celular"
										placeholder="celular"
										class="form-control"
										type="text">
									</input>
								</div> 
							</div>
							<div class="col-md-6 mt-1">
								<label for="email" class="font-weight-bold">
									Correo
									<small v-if="data_errors.email != undefined" class="form-text error-input p-1 alert-danger fade show">
										{{ data_errors.email[0] }}
									</small>
								</label>
								<div class="input-group">
									<input
									v-model="prospectos.email"
									placeholder="email"
									class="form-control"
									type="email">
									</input>
								</div> 
							</div>
							<div class="col-md-12 mt-1">
								<label for="estatus" class="font-weight-bold">
									Estatus
									<small v-if="data_errors.estatus != undefined" class="form-text error-input p-1 alert-danger fade show">
										{{ data_errors.estatus[0] }}
									</small>
								</label>
                <div class="input-group">
									<select 
										v-model="prospectos.estatus"
										placeholder="Selecciona un estatus"
										class="form-control minimal">
										<option :value="1"> Activo </option>
										<option :value="0"> Inactivo </option>
									</select>
								</div> 
							</div> 

							<div class="col-md-12 mt-2">
								<button type="button" class="btn btn-primary btn-block" @click="addProspecto" v-if="!isEditing">
									Agregar
								</button>
								<button class="btn btn-secondary" type="button" @click="cancelarEdit()" v-if="isEditing">
									Cancelar
								</button>
								<button class="btn btn-primary pull-right" type="button" @click="updateProspecto()" v-if="isEditing">
									Actualizar
								</button>
				      </div>

      			</div>
    			</div>
				</div>

			</div>

			<div class="col md-8">
				<div class="card border-info">
					<div class="card-header bg-light">
						<h4>
					  	Panel de prospectos
						</h4>
					</div>
					<div class="card-body">
						<div class="row mt-1 media-query-consultar">
							<div class="col-md-12">
								<vuetable ref="vuetable"
									:api-url="'/home/show'"
									track-by="id"
									:fields="fields"
									:css="css.tableNotResponse"
									:show-sort-icons="true"
									:per-page="10"
									pagination-path="meta"
									:append-params="moreParams"
									@vuetable:pagination-data="onPaginationData">

									<div slot="nombre-slot" slot-scope="props">
										{{ props.rowData.nombre }} 
										{{ props.rowData.apellido_paterno }} 
										{{ props.rowData.apellido_materno }}
									</div>

									<div slot="estatus-slot" slot-scope="props">
										<i class="fa fa-check-circle fa-2x text-success" v-if="props.rowData.estatus">
										</i>
										<i class="fa fa-times-circle fa-2x text-warning" v-else>
										</i>
									</div>

									<div slot="opciones-slot" slot-scope="props">
										<a class="block" @click="confirmarEliminar(props.rowData)" data-toggle="tooltip" data-placement="top" title="Eliminar">
											<i class="fa fa-trash text-danger fa-1x">
											</i>
										</a>
										<a class="text-info inline-block" @click="editProspecto(props.rowData)">
				              <i class="fa fa-edit text-info fa-1x ml-2">
      								</i>
				            </a>
										<a class="text-primary font-weight-bold block fa-1x mt-1 ml-2" 
											:href="'/prospectos/'+props.rowData.id" data-toggle="tooltip" 
											data-placement="top" title="llamadas">
											<i class="fa fa-phone text-success fa-1x">
											</i>
										</a>
									</div>
									
	              </vuetable>

	              <div style="margin-top:10px">
						      <div style="float: right;">
						        <vuetable-pagination ref="pagination"
											:css="css.pagination"
											class="pull-right"
											@vuetable-pagination:change-page="onChangePage">
						        </vuetable-pagination>
						      </div>
						  	</div>

							</div>
						</div>
					</div>
				</div>
			</div>

		</div>

	</div>
</template>

<script>

	import Multiselect from 'vue-multiselect';
	import Vuetable from "vuetable-2";
	import VuetablePagination from "../utils/VuetablePaginationBootstrap4.vue";
	import VuetablePaginationInfo from 'vuetable-2/src/components/VuetablePaginationInfo'
	import CssConfig from "../utils/TableStyles";
	import VueEvents from 'vue-events'
	Vue.use(VueEvents)

	export default {
		props: [],
		components: {
			Vuetable,
			VuetablePagination,
			VuetablePaginationInfo,
			Multiselect,
		},
		data() {
			return {
				css: CssConfig,
				fields: [
					{
						name: "nombre-slot",
						title: 'Nombre',
						titleClass: 'center',
						sortField: "nombre",
					},
					{
						name: "celular",
						title: 'Celular',
						titleClass: 'center',
						sortField: "celular",
					},
					{
						name: "email",
						title: 'Email',
						titleClass: 'center',
						sortField: "email",
					},
					{
						name: "estatus-slot",
						title: 'Estatus',
						titleClass: 'center',
						sortField: "estatus",
					},
					{
						name: "opciones-slot",
						title: 'Opciones',
						titleClass: 'center'
					}
				],
				moreParams: {},
				prospectos: {
				  nombre: '',
				  apellido_paterno: '',
				  apellido_materno: '',
					celular: '',
					estatus: false,
					email: ''
				},
				data_errors: [],
				isEditing: false,

			}
		},
		created(){

		},
		methods: {

			addProspecto() {

				axios.post('/home/create', {
					...this.prospectos
				}).then(res => {

					let response = res.data;
					this.$events.fire('filter-reset');
					this.$snotify.success(response.message, 'Correcto', {
						timeout: 4000,
						showProgressBar: true,
						closeOnClick: true,
						pauseOnHover: true
					});

					this.prospectos = { 
						nombre: '',
						apellido_paterno: '',
						apellido_materno: '',
						celular: '',
						estatus: '',
						email: ''
					};

				}).catch(err => {

					let response = err.response.data;
					console.log(response);
					this.$snotify.error(response.message, 'Error', {
						timeout: 4000,
						showProgressBar: true,
						closeOnClick: true,
						pauseOnHover: true
					});

					this.data_errors = err.response.data.errors;

				})

			},

			confirmarEliminar(prospecto){

				this.$snotify.warning('Esta seguro de eliminarlo ?', 'Aviso', {
					timeout: 0,
					showProgressBar: false,
					closeOnClick: false,
					pauseOnHover: true,
					buttons: [
						{
							text: 'Si', 
							action: (toast) => {
								this.removeProspecto(prospecto)
								this.$snotify.remove(toast.id); 
							}, 
							bold: true
						},
						{
							text: 'Cancelar', 
							action: (toast) => {
								this.$snotify.remove(toast.id); 
							}, 
							bold: true
						},
					]
				});
				
			},

			removeProspecto(prospecto){
			  axios.delete('/prospectos/'+prospecto.id).then(res => {
					this.onFilterReset();
					let response = res.data;
					let delete_row = {};
					delete_row = response.prospecto;
					this.$events.fire('delete-rol', delete_row);
			    this.$snotify.success('Se elimino de la lista', 'Correcto', {
						timeout: 4000,
						showProgressBar: true,
						closeOnClick: true,
						pauseOnHover: true
					});
			  }).catch(error => {
			        
			  });

			},

			cancelarEdit(){
        this.isEditing = false;
        this.prospectos = {
					nombre: '',
				  apellido_paterno: '',
				  apellido_materno: '',
					celular: '',
					estatus: false,
					email: ''
        }
      },

			editProspecto(prospecto){
				console.log("prospecto:", prospecto);
				this.isEditing = true;
				this.prospectos = {
					id: prospecto.id,
					nombre: prospecto.nombre,
					apellido_paterno: prospecto.apellido_paterno,
					apellido_materno: prospecto.apellido_materno,
					celular: prospecto.celular,
					estatus: prospecto.estatus,
					email: prospecto.email
				};
				console.log(this.prospectos);
			},

			updateProspecto(){
				axios.put('/prospectos/'+this.prospectos.id, {
					...this.prospectos
				}).then(res => {
					this.isEditing=false;
					this.not_direccion = false;
					let response = res.data;
					this.onFilterReset();
					this.$snotify.success(response.message, 'Correcto', {
						timeout: 4000,
						showProgressBar: true,
						closeOnClick: true,
						pauseOnHover: true
					});
					this.prospectos = {
						nombre: '',
						apellido_paterno: '',
						apellido_materno: '',
						celular: '',
						estatus: false,
						email: ''
					}
				}).catch(err => {

          let response = err.response.data;
          this.$snotify.error(response.message, 'Error', {
						timeout: 4000,
						showProgressBar: true,
						closeOnClick: true,
						pauseOnHover: true
					});
          this.data_errors = err.response.data.errors;

        });
      },

			onFilterReset () {
				this.moreParams = {}
				Vue.nextTick( () => this.$refs.vuetable.refresh())
			},

			onPaginationData(paginationData) {
				this.$refs.pagination.setPaginationData(paginationData);
				//this.$refs.paginationInfo.setPaginationData(paginationData);
			},

			onChangePage (page) {
				this.$refs.vuetable.changePage(page)
			},

		},
		mounted() {
			this.$events.$on('filter-reset', e => this.onFilterReset());
    },
		
	}

	
</script>
