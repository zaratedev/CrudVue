@extends('template.layout')
@section('title', 'Home')
@section('content')
  <div class="container">
    <div class="columns personal-menu text-center vertical-center">
      <div class="column">
        Zona de pruebas
      </div>
    </div>
    <div class="columns margin0 tile">
      <div class="column is-2 line-der">
        <aside class="menu">
          <p class="menu-label">
            Menu Principal
          </p>
          <ul class="menu-list">
            <li @click="menu=0" class="hand-option"><a :class="{'is-active' : menu==0}">Dashboard</a></li>
            <li @click="menu=1" class="hand-option"><a :class="{'is-active' : menu==1}">Departamentos</a></li>
            <li @click="menu=2" class="hand-option"><a :class="{'is-active' : menu==2}">Cargos</a></li>
            <li @click="menu=3" class="hand-option"><a :class="{'is-active' : menu==3}">Empleados</a></li>
          </ul>
        </aside>
      </div>
      <div class="column personal-content" v-if="menu==0">
        <div class="columns text-center">
          <div class="column">
            <h3>Dashboard</h3>
          </div>
        </div>
        <div class="columns text-center">
          <div class="column">
            <h1>Bienvenido</h1>
          </div>
        </div>
      </div>
      <div class="column" v-if="menu==1">
        <div class="columns">
          <div class="column text-center">
            <h3>Departamentos</h3>
          </div>
          <div class="column">
            <a class="button is-success" @click="openModal('departure','create')">Agregar Departamento</a>
          </div>
        </div>
        <div class="columns">
          <div class="column">
            <div v-if="!departures.length">
              No hay departamentos
            </div>
            <table v-else class="table">
              <thead>
                <th>#</th>
                <th>Titulo</th>
                <th>Editar</th>
              </thead>
              <tbody>
                <tr v-for="departure in departures">
                  <td>@{{ departure.id }}</td>
                  <td>@{{ departure.title }}</td>
                  <td @click="openModal('departure','delete',departure)">
                    <i class="fa fa-ban"></i>
                  </td>
                  <td @click="openModal('departure','update', departure)">
                    <i class="fa fa-pencil" aria-hidden="true"></i>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="column" v-if="menu==2">
        <div class="columns">
          <div class="column text-center">
            <h3>Cargo</h3>
          </div>
          <div class="column" v-if="departures.length">
            <a class="button is-success" @click="openModal('position','create')">Agregar Cargo</a>
          </div>
          <div class="column" v-else>
            <span class="text-danger">
              Debe existir un departamento por lo menos
            </span>
          </div>
        </div>
        <div class="columns">
          <div class="column">
            <div v-if="!positions.length">
              No hay cargos
            </div>
            <table v-else class="table">
              <thead>
                <th>#</th>
                <th>Titulo</th>
                <th>Eliminar</th>
                <th>Editar</th>
              </thead>
              <tbody>
                <tr v-for="position in positions">
                  <td>@{{ position.id }}</td>
                  <td>@{{ position.title }}</td>
                  <td @click="openModal('position','delete', position)">
                    <i class="fa fa-ban" aria-hidden="true"></i>
                  </td>
                  <td @click="openModal('position','update', position)">
                    <i class="fa fa-pencil" aria-hidden="true"></i>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="column" v-if="menu==3">
        <div class="columns">
          <div class="column text-center">
            <h3>Empleado</h3>
          </div>
          <div class="column">
            Tabla empleados
          </div>
        </div>
      </div>
    </div>
    <div class="columns margin0 text-center vertical-center personal-menu">
      <div class="column">
        Empleados 0
      </div>
      <div class="column">
        Departamentos @{{ departures.length }}
      </div>
      <div class="column">
        Cargo 0
      </div>
    </div>
  </div>
  <!-- Modal -->
  <div class="modal" :class="{'is-active' : modalGeneral}">
    <div class="modal-backgroud"></div>
    <div class="modal-content">
      <div class="content">
        <h3 class="text-center">@{{titleModal}}</h3>
        <div class="field">
          <label class="label">@{{messageModal}}</label>
          <p class="control" v-if="modalDeparture != 0">
            <input class="input" placeholder="Departamento" v-model="titleDeparture" :readonly="modalDeparture == 3">
          </p>
          <div v-show="errorTitleDeparture" class="columns text-center">
            <div class="column text-center text-danger">
              El nombre del departamento no puede estar vacio
            </div>
          </div>
          <p class="control" v-if="modalPosition">
            <input class="input" placeholder="Cargo" v-model="titlePosition" :readonly="modalPosition == 3">
            <select class="select" :readonly="modalPosition == 3" v-model="idDeparturePosition">
              <option v-for="departure in departures" :value="departure.id">@{{ departure.ttile }}</option>
            </select>
          </p>
          <div v-show="errorTitleDeparture" class="columns text-center">
            <div class="column text-center text-danger">
              El nombre del cargo no puede estar vacio
            </div>
          </div>
          <div class="columns button-content">
            <div class="column">
              <a class="button is-success" @click="createDeparture()" v-if="modalDeparture == 1">Aceptar</a>
              <a class="button is-success" @click="updateDeparture()" v-if="modalDeparture == 2">Aceptar</a>
              <a class="button is-success" @click="destroyDeparture()" v-if="modalDeparture == 3">Aceptar</a>
              <a class="button is-success" @click="createPosition()" v-if="modalPosition==1">Aceptar</a>
              <a class="button is-success" @click="updatePosition()" v-if="modalPosition==2">Aceptar</a>
              <a class="button is-success" @click="destroyPosition()" v-if="modalPosition==3">Aceptar</a>
            </div>
            <div class="column">
              <a class="button is-dnager" @click="closeModal()">Cancelar</a>
            </div>
          </div>
        </div>
      </div>
      <button class="modal-close" @click="closeModal()"></button>
    </div>
  </div>
@endsection
@section('script')
  <script type="text/javascript">
    let elemento = new Vue({
      el: '.app',
      mounted: function () {
        this.allQuery();
      },
      data: {
        menu: 0,
        modalGeneral: 0,
        titleModal: '',
        messageModal: '',
        /*** Departure **/
        modalDeparture: 0,
        titleDeparture: '',
        errorTitleDeparture: 0,
        departures: [],
        /*** Positions ***/
        positions: [],
        modalPosition: 0,
        titlePosition: '',
        errorTitlePosition: 0,
        idDeparturePosition: 0
      },
      watch: {
        modalGeneral: function ( value ) {
          if(!value) this.allQuery();
        }
      },
      methods: {
        openModal(type, action, data = []) {
          switch ( type ) {
            case "departure": {
              switch ( action ) {
                case 'create': {
                  this.modalGeneral = 1;
                  this.titleModal = 'Creación de Departamento';
                  this.messageModal = 'Ingrese el titulo del departamento';
                  this.modalDeparture = 1;
                  this.titleDeparture = '';
                  this.errorTitleDeparture = 0;
                  break;
                }
                case 'update': {
                  this.modalGeneral = 1;
                  this.titleModal = 'Modificación de Departamento';
                  this.messageModal = 'Modifique el titulo del departamento';
                  this.modalDeparture = 2;
                  this.titleDeparture = data['title'];
                  this.errorTitleDeparture = 0;
                  this.idDeparture = data['id'];
                  break;
                }
                case 'delete': {
                  this.titleModal = 'Eliminación de Departamento';
                  this.messageModal = 'Titulo del departamento';
                  this.modalDeparture = 3;
                  this.modalGeneral = 1;
                  this.titleDeparture = data['title'];
                  this.idDeparture = data['id'];
                  break;
                }
              }
              break;
            }
            case "position": {
              switch ( action ) {
                case 'create': {
                  this.modalGeneral = 1;
                  this.titleModal = 'Creación de Cargo';
                  this.messageModal = 'Ingrese el titulo del Cargo';
                  this.modalPosition = 1;
                  this.titlePosition = '';
                  this.errorTitlePosition = 0;
                  this.idDeparturePosition = this.departures[0].id;
                  break;
                }
                case 'update': {
                  break;
                }
                case 'delete': {
                  break;
                }
              }
              break;
            }
            case "employee": {
              switch ( action ) {
                case 'create': {
                  break;
                }
                case 'update': {
                  break;
                }
                case 'delete': {
                  break;
                }
              }
              break;
            }
            break;
          }
        },
        closeModal(){
          this.modalGeneral = 0;
          this.titleModal = '';
          this.messageModal = '';
        },
        createDeparture(){
          if ( this.titleDeparture == '' ) {
            this.errorTitleDeparture = 1;
            return;
          }
          let me = this;

          axios.post('{{ route('departurecreate')}}', {
            'title': this.titleDeparture
          })
          .then( function ( response ) {
            me.titleDeparture = '';
            me.errorTitleDeparture = 0;
            me.modalDeparture = 0;
            me.closeModal();
          })
          .cath( function ( error ) {
            console.log(error);
          })
        },
        allQuery() {
          let me = this;
          axios.get('{{route('allQuery')}}').then( function ( response ) {
            let answer = response.data;
            me.departures = answer.departures;
            me.positions = answer.positions;
          }).catch( function ( error ) {
            console.log( error );
          })
        },
        destroyDeparture() {
          let me = this;
          axios.delete('{{ url('/departure/delete')}}'+'/'+this.idDeparture)
          .then( function ( response ) {
            me.idDeparture = 0;
            me.titleDeparture = '';
            me.modalDeparture = 0;
            me.closeModal();
          })
          .catch( function ( error ) {b
            console.log('error:' + error);
          })
        },
        updateDeparture() {
          if (this.titleDeparture == '') {
            this.errorTitleDeparture = 1;
            return;
          }

          let me = this;

          axios.put('{{route('departureupdate')}}', {
            'title': this.titleDeparture,
            'id': this.idDeparture
          })
          .then( (response)=> {
            me.titleDeparture = '';
            me.idDeparture = 0;
            me.errorTitleDeparture = 0;
            me.modalDeparture = 0;
            me.closeModal();
          })
          .catch( (error) => {
            console.log('error: ' + error);
          })
        },
        updatePosition() {},
        destroyPosition() {},
        createPosition() {},
      }
    })
  </script>
@endsection
