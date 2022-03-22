<template>
    <form id="contact-form" method="POST" name="formUrl" v-on:submit.prevent="scanUrl()"> 
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="card" style="background-color: #f3f3f3;">
                        <div class="card-header">Ingrese su URL</div>

                        <div class="card-body">
                            <!--URL--> 
                            <input type="text" id="txtUrl" class="form-control" placeholder="URL" name="Url" v-model="Url">
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">
                        <!--BOTON--> 
                        <button class="btn btn-lg btn-info" id="btnEnviar" type="submit"> 
                            <i class="fas fa-paper-plane"></i> <span class="45">CONSULTAR</span> 
                        </button> 
                    </div>
                </div>
            </div>
    </form>
</template>

<script>
    import Swal from 'sweetalert2'
    export default {
        data() {
            return {
                Url: '',
            }
        },
        methods: {
            scanUrl(){
                //console.log('hey1-'+this.Url);

                Swal.fire({
                  title: 'Revisando',
                  html: '',
                  allowOutsideClick: false,
                  footer: '<p class="text-muted">2022</p>',
                  didOpen: () => {
                    Swal.showLoading()
                  }
                }).then((result) => {
                  
                  
                })

                axios.post('submit', {
                    Url: this.Url
                  })
                  .then(function (response) {
                    if (response.data[4]) {
                        let msg = '';
                        if (response.data[3]) {
                            msg = 'Si utiliza CSS interno';
                        }else{
                            msg = 'No utiliza CSS interno';
                        }

                        Swal.fire({
                          icon: 'success',
                          title: 'Resultado',
                          html: '<p>'+response.data[0].Url+
                              '</p><p>'+msg+
                              '</p><p>Archivos CSS : '+response.data[1]+
                              '</p><p>Imágenes :'+response.data[2]+
                              '</p>',
                          footer: '<p class="text-muted">2022</p>'
                        })
                    }else{
                        Swal.fire({
                          icon: 'error',
                          title: 'Error',
                          html: '<p>Debe ingresar una URL valida</p>',
                          footer: '<p class="text-muted">2022</p>'
                        })
                    }

                    
                    //console.log(response.data);
                    //console.log('Fin');
                  })
                  .catch(function (error) {
                    //console.log(error);
                  });
                
            }
        }
    }
</script>
