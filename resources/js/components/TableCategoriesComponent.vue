<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header"><h2>Listado de Categorias</h2></div>

                    <div class="card-body">
                      <table class="table" id="table_categories">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Descripción</th>
                            <th scope="col">Opciones</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-for="categorie in categories">
                            <th scope="row">{{ categorie.id }}</th>
                            <td>{{ categorie.name }}</td>
                            <td>{{ categorie.description }}</td>
                            <td>
                            <a @click="productsCategory(categorie.id)"> <span class="fa fa-fw fa-folder-open" data-toggle="modal" data-target="#modal-products"></span> </a> 
                            <a @click="deleteCategorie(categorie.id)"> <span class="fa fa-fw fa-trash"></span> </a> 
                            <a @click="editCategorie(categorie.id)"> <span class="fa fa-edit" data-toggle="modal" data-target="#modal-default"></span> </a> </td>
                          </tr>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-default" style="display: none;">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Editar Categoría</h4>
              </div>
              <div class="modal-body">
                <form @submit.prevent="updateCategorie" action="" enctype="multipart/form-data">
                   <div class="form-group">
                        <label for="name">Nombre:</label>
                        <input type="text" id="name" v-model="categorie.name" class="form-control">
                   </div>
                   <div class="form-group">
                        <label for="stock">Descripción:</label>
                        <input type="text" id="stock" v-model="categorie.description" class="form-control">
                   </div>
                   <input type="hidden" name="_method" value="PUT">
                   <button type="submit" class="btn btn-primary">Guardar</button>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" id="close" data-dismiss="modal">Cerrar</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>


        <div class="modal fade" id="modal-products" style="display: none;">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Productos de la categoría: <span id="categorie_name"></span></h4>
              </div>
              <div class="modal-body">
                <table class="table" id="table_products">
                    <thead>
                      <tr>
                        <th scope="col">Nombre</th>
                        <th scope="col">Descripción</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="product in products">
                        <td>{{ product.name }}</td>
                        <td>{{ product.description }}</td>
                      </tr>
                      </tr>
                    </tbody>
                  </table>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" id="close" data-dismiss="modal">Cerrar</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>

        
    </div>
</template>

<script>
    import datatables from 'datatables'
    export default {
        mounted(){
            this.getCategories();
        },
        data() { 
            return {
                categories: [],
                products: [],
                categorie: {
                    id: '',
                    name: '',
                    description: ''
                }
            }
        },
        methods: {
            getCategories(){
                axios.get('./getCategories')
                    .then(response => {
                        this.categories = response.data;
                        this.tableCategories();
                    });

            },
            tableCategories(){
                $(document).ready( function () {
                    $('#table_categories').DataTable();
                });
            },
            tableProducts(){
                $(document).ready( function () {
                    $('#table_products').DataTable();
                });
            },
            deleteCategorie(category){
                let result = window.confirm('¿Desea eliminar esta categoría?');

                if(result){
                    axios.delete('./categories/'+category)
                    .then(response => {
                       if(response.data == 1){
                        alert('Categoría eliminada');
                       }else{
                        alert('Error al eliminar');
                       }
                       this.getCategories();
                    });
                }else{
                    return false;
                }
                
            },
            updateCategorie(){
                let formData = new FormData();

                if(this.categorie.name == '' || this.categorie.description == ''){
                    alert('Debe rellenar todos los campos');
                }else{
                    formData.append('id', this.categorie.id);
                    formData.append('name', this.categorie.name);
                    formData.append('description', this.categorie.description);

                    axios.post('./updateCategorie', formData)
                        .then(response => {
                             alert('Categoría actualizada exitosamente');
                             this.getCategories();
                             document.getElementById('close').click();
                            
                        });
                }   
            },
            editCategorie(categorie){

                axios.get('./categories/'+categorie)
                .then(response => {
                    this.categorie.id = response.data.id;
                    this.categorie.name = response.data.name;
                    this.categorie.description = response.data.description;
                });
            },
            productsCategory(categorie){

                let name_category = '';

                for (let i = 0; i < this.categories.length ; i++) {
                    if(this.categories[i].id == categorie){
                        this.products = this.categories[i].products;
                        name_category = this.categories[i].name;
                    } 
                }

                document.getElementById('categorie_name').textContent  = name_category;
                this.tableProducts();
            }
        },
    }
</script>
