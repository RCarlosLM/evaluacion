<template>
	<div>

		<div class="row mt-3">

			<div class="col-md-4">
        <div class="card border-info">
					<div class="card-header bg-light">
						<h4>
							Llamadas
						</h4>
					</div>
          <div class="card-body">
            <div class="row">
							<div class="col-md-12">
								<label for="asunto" class="font-weight-bold">
									Asunto
								  	<small v-if="data_errors.asunto" class="form-text error-input p-1 alert-danger fade show">
								    	{{ data_errors.asunto[0] }}
								  	</small>
								</label>
								<div class="input-group">
									<input
										v-model="llamadas.asunto"
										placeholder="asunto"
										class="form-control"
										type="text">
									</input>
								</div> 
							</div>
							<div class="col-md-12 mt-1">
								<label for="fecha" class="font-weight-bold">
									Fecha
									<small v-if="data_errors.fecha" class="form-text error-input p-1 alert-danger fade show">
										{{ data_errors.fecha[0] }}
									</small>
								</label>
								<div class="input-group">
									<input
										v-model="llamadas.fecha"
										class="form-control"
										type="date">
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
										v-model="llamadas.estatus"
										placeholder="Selecciona un estatus"
										class="form-control minimal">
										<option :value="1"> Pendiente </option>
										<option :value="2"> realizada </option>
										<option :value="3"> no realizada </option>
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
					  	Panel de llamadas
						</h4>
					</div>
					<div class="card-body">
						<div class="row mt-1 media-query-consultar">
							<div class="col-md-12">
								<vuetable ref="vuetable"
									:api-url="'/llamadas/show/'+prospecto.id"
									track-by="id"
									:fields="fields"
									:css="css.tableNotResponse"
									:show-sort-icons="true"
									:per-page="10"
									pagination-path="meta"
									:append-params="moreParams"
									@vuetable:pagination-data="onPaginationData">

									<div slot="estatus-slot" slot-scope="props">
										<span v-if="props.rowData.estatus == '1'" class="font-weight-bold text-warning">
											Pendiente
										</span>
										<span v-if="props.rowData.estatus == '2'" class="font-weight-bold text-success">
											Realizada
										</span>
										<span v-if="props.rowData.estatus == '3'" class="font-weight-bold text-danger">
											Realizada
										</span>
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
	import moment from "moment";
	import VuetablePagination from "../utils/VuetablePaginationBootstrap4.vue";
	import VuetablePaginationInfo from 'vuetable-2/src/components/VuetablePaginationInfo'
	import CssConfig from "../utils/TableStyles";
	import VueEvents from 'vue-events'
	Vue.use(VueEvents)

	export default {
		props: ['prospecto'],
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
						name: "asunto",
						title: 'asunto',
						titleClass: 'center',
						sortField: "asunto",
					},
					{
						name: "fecha",
						title: 'Fecha',
						titleClass: 'center',
						sortField: "fecha",
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
				llamadas: {
				  asunto: '',
				  fecha: '',
					estatus: ''
				},
				data_errors: [],
				isEditing: false,

			}
		},
		created(){

		},
		methods: {

			addProspecto() {

				axios.post('/llamadas/create', {
					...this.llamadas,
					prospecto: this.prospecto.id
				}).then(res => {

					let response = res.data;
					this.$events.fire('filter-reset');
					this.$snotify.success(response.message, 'Correcto', {
						timeout: 4000,
						showProgressBar: true,
						closeOnClick: true,
						pauseOnHover: true
					});

					this.llamadas = { 
						asunto: '',
						fecha: '',
						estatus: ''
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

			confirmarEliminar(llamada){

				this.$snotify.warning('Esta seguro de eliminarla ?', 'Aviso', {
					timeout: 0,
					showProgressBar: false,
					closeOnClick: false,
					pauseOnHover: true,
					buttons: [
						{
							text: 'Si', 
							action: (toast) => {
								this.removeLlamada(llamada)
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

			removeLlamada(llamada){
			  axios.delete('/llamadas/'+llamada.id).then(res => {
					this.onFilterReset();
					let response = res.data;
					let delete_row = {};
					delete_row = response.llamada;
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
        this.llamadas = {
					asunto: '',
				  fecha: '',
					estatus: ''
        }
      },

			editProspecto(llamada){
				console.log("llamada:", llamada);
				this.isEditing = true;
				this.llamadas = {
					id: llamada.id,
					asunto: llamada.asunto,
					fecha: llamada.fecha,
					estatus: llamada.estatus,
				};
				console.log(this.llamadas);
			},

			updateProspecto(){
				axios.put('/llamadas/'+this.llamadas.id, {
					...this.llamadas,
					prospecto: this.prospecto.id
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
					this.llamadas = {
						asunto: '',
						fecha: '',
						estatus: ''
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
