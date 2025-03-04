<script lang="ts">
import { defineComponent } from 'vue'
import * as MenuService from "@/modules/Authorization/services/MenuService"
import { alertWithToast } from '@/utils/toast';

export default defineComponent({
  components: {    
    //AppLoadingButton,
  }, 
  data() {
    return {
      menus: [],
      selVal : 0,
      selTexs : [],
      nivel: 0,
      isDisabled: false,
      form: {
        title: '',
        menu_id: 0,
        path: 'dashboard',
        icon: 'fas fa-home',
        sort: 0
      }   
    }
  },
  created: function() {
    this.stepFrontward(0);
  },    
  methods: {
    validateForm() {
      let element = document.querySelector("input:invalid");
      return element === null ? true : false;
    },         
    closeModal111: function () {
      this.$emit('closeModal0');        
    },
    showSelected: function () {
      let menu = (this.menus.find(element => element.id === this.selVal));
      this.selTexs.push({ 
        nivel: this.nivel,
        title: menu.title,
        id   : menu.menu_id 
      });
    },   
    stepFrontward: function (menuId = 0, step = true ) {
      menuId= !menuId ? 0 : menuId;      
      MenuService.getMenusChildren(menuId).then((res) => {
        if (step) {
            if (this.selVal) {                    
              this.showSelected();
              this.nivel++;
              this.form.menu_id = this.selVal;
            }
          } else {
            this.nivel--;
            this.form.menu_id = res.data[0].menu_id;
          }
          this.menus = [ {id:0 , title:'Seleccione...'} ].concat(res.data);
          this.selVal = 0;          
      })
    },
    stepBackward: function (id) {
      this.selTexs.pop();
      this.stepFrontward(id, false);
    },
    fastBackward: function (id) {
      this.nivel = 0;
      this.selTexs = [];
      this.stepFrontward(0);
    },
    async submit(){  
        try {
          const response = await MenuService.insertMenu(this.form)
          alertWithToast(response.data.message, 'success')
          this.$emit('saved');        
        } catch (error) {
          const message = error.response.data.message || 'Error inesperado';
          alertWithToast(message, 'error')
        }
    },

  }
})
</script>

<template>
  <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
    <div class="fixed inset-0 transition-opacity">
      <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
    </div>
    <!-- This element is to trick the browser into centering the modal contents. -->
    <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>​
    <div
      class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
      role="dialog"
      aria-modal="true"
      aria-labelledby="modal-headline">      
      <form @submit.prevent="submit">
        <div class="bg-base-200 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
          <table style="width: 100%" id="main">                
            <tr>
              <th colspan="2" class="text-center font-bold py-2">Crear nueva opción del menú</th>
            </tr>
            <tr class="lospare">
              <td colspan="2" >
                <table width="100%">
                  <tr>
                    <td align="left" id="id_td_descripcion" width="50%">
                      Nombre
                    </td>
                    <td>
                      <input
                        type="text"
                        name="menu"
                        class="form-control"
                        v-model="form.title"
                        placeholder="Opction..." required/>
                    </td>
                  </tr>
                  <tr>
                    <td align="left" width="50%">
                      Ruta (nivel {{ nivel }})
                    </td>
                    <td>
                      <input
                        type="text"
                        name="path"
                        class="form-control"
                        v-model="form.path"
                        placeholder="Path..." required/>
                    </td>
                  </tr>
                  <tr>
                    <td align="left" width="50%">
                      Icon (nivel {{ nivel }})
                    </td>
                    <td>
                      <input
                        type="text"
                        name="icon"
                        class="form-control"
                        v-model="form.icon"
                        placeholder="Icon..." required/>
                    </td>
                  </tr>
                </table>
                <!--/form-->
              </td>
            </tr>
          </table>
        
        </div>
        <div class="bg-base-100 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
          <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
            <button
              type="submit"              
              class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-[#e2384f] text-base leading-6 font-medium text-white shadow-sm hover:bg-[#a7404e] transition ease-in-out duration-150 sm:text-sm sm:leading-5">
              Crear
            </button>
          </span>
        </div>
      </form>
    </div>
  </div>
</template>
