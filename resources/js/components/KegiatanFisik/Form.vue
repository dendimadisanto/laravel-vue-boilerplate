<template>
    <div class="form-kegiatan">
        <div class="row">
            <div class="col-md-7" style="max-height:580px;">
                <div class="card">
                    <h5 class="card-header" style="background: #4b71dd;color: white;">Lokasi</h5>
                    <div class="card-body" style="overflow:auto">
                        <div class="map">
                        <title>Lokasi</title>
                        <l-map style="height: 490px; width: 100%" :zoom="zoom" :center="center">
                                <l-control-layers position="topright"  ></l-control-layers>
                                <l-tile-layer
                                    v-for="tileProvider in tileProviders"
                                    :key="tileProvider.name"
                                    :name="tileProvider.name"
                                    :visible="tileProvider.visible"
                                    :url="tileProvider.url"
                                    :attribution="tileProvider.attribution"
                                    layer-type="base"/>
                                <l-marker :lat-lng="center" :draggable="isdrag" v-on:drag="dragging"></l-marker>
                                </l-map>
                    </div>
                    </div>
                    </div>
            </div>
             <div class="col-md-5" style="max-height:580px;">
                <div class="card" style="height:100%">
                <h5 class="card-header" style="background: #4b71dd;color: white;">{{title}}</h5>
                <div class="card-body" style="overflow:auto">
                    <form @submit.prevent="simpan">
                        <div class="form-group">
                            <label >Nama</label>
                             <input type="text" style="display:none" class="form-control" v-model="form.id">
                            <input type="text" class="form-control" v-model="form.kegiatan" :class="{'is-invalid' : errors.kegiatan}">
                            <div class="invalid-feedback">
                                  {{errors.kegiatan ? errors.kegiatan[0] : '' }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label >Jenis Kegiatan</label>
                            <input type="text" class="form-control"  v-model="form.jenis_kegiatan" :class="{'is-invalid' : errors.jenis_kegiatan}">
                            <div class="invalid-feedback">
                                  {{errors.jenis_kegiatan ? errors.jenis_kegiatan[0] : '' }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label >Lokasi (drag and drop dari peta)</label>
                            <div class="row">
                                <div class="col">
                                <input type="text" class="form-control" placeholder="Latitude" readonly v-model="form.lat" :class="{'is-invalid' : errors.lat}">
                                </div>
                                <div class="col">
                                <input type="text" class="form-control" placeholder="Longitude" readonly v-model="form.lng" :class="{'is-invalid' : errors.lng}">
                                </div>
                            </div>
                        </div>
                         <div class="form-group">
                            <label >Alamat</label>
                            <input type="text" class="form-control" v-model="form.alamat">
                        </div>
                         <div class="form-group">
                            <label >Sumber Dana</label>
                            <select class="form-control" v-model="form.sumber_dana_id" :class="{'is-invalid' : errors.sumber_dana_id}">
                                <option value="0">-- Pilih</option>
                                <option v-for="(value, index) in sumberDana" :value="value.id">{{value.nama}}</option>
                            </select>
                             <div class="invalid-feedback">
                                  {{errors.sumber_dana_id ? errors.sumber_dana_id[0] : '' }}
                            </div>
                        </div>
                         <div class="form-group">
                            <label >Anggaran</label>
                            <input type="number" class="form-control" v-model="form.anggaran" step=any>
                        </div>
                         <div class="form-group">
                            <label >Volume</label>
                            <input type="number" class="form-control" v-model="form.volume">
                        </div>
                         <div class="form-group">
                            <label >Pelaksana</label>
                            <input type="text" class="form-control" v-model="form.pelaksana">
                        </div>
                          <div class="form-group">
                            <label >Tahun</label>
                            <select class="form-control" v-model="form.tahun">
                                <option v-for=" i in 3" :value="yearNow - (3 - i)">{{yearNow - (3 - i)}}</option>
                                <option v-for=" i in 3" :value="yearNow + 1">{{yearNow + i}}</option>

                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import {LMap, LTileLayer, LControlLayers, LGeoJson, LMarker,LPopup, LIcon} from 'vue2-leaflet';
export default {
     components: {
    LMap,
    LTileLayer,
    LControlLayers,
    LGeoJson,
    LMarker,
    LPopup,
    LIcon
  },
  data () {
    return {
      url:'https://api.mapbox.com/styles/v1/mapbox/streets-v11/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoiZGVuZGkiLCJhIjoiY2thdnM4bzJsMTU4ZTJ1cGhvd3V6cGF4ZyJ9.XUd4BVBF12fVpfwUoWv0Hg',
      zoom: 15,
      isdrag:true,
      center: [-7.898452568570932, 110.29196285286662],
      tileProviders: [
        {
          name: 'StreetMap',
          visible: true,
          attribution:
            '&copy; <a target="_blank" href="http://osm.org/copyright">OpenStreetMap</a> contributors',
            url:'https://api.mapbox.com/styles/v1/mapbox/streets-v11/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoiZGVuZGkiLCJhIjoiY2thdnM4bzJsMTU4ZTJ1cGhvd3V6cGF4ZyJ9.XUd4BVBF12fVpfwUoWv0Hg',
        },
        {
          name: 'Satelite',
          visible: false,
         url:'https://api.mapbox.com/styles/v1/mapbox/satellite-streets-v11/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoiZGVuZGkiLCJhIjoiY2thdnM4bzJsMTU4ZTJ1cGhvd3V6cGF4ZyJ9.XUd4BVBF12fVpfwUoWv0Hg',
          attribution:
            'Map data: &copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>, <a href="http://viewfinderpanoramas.org">SRTM</a> | Map style: &copy; <a href="https://opentopomap.org">OpenTopoMap</a> (<a href="https://creativecommons.org/licenses/by-sa/3.0/">CC-BY-SA</a>)',
        },
      ],
       marker:[ [-7.93493,110.481997],[-7.7795895,110.34770333]],
       iconSize: 64,
       form:{
           id:0,
           kegiatan:'',
           jenis_kegiatan:'',
           alamat:'',
           sumber_dana_id:'0',
           anggaran:'',
           volume:'',
           pelaksana:'',
           tahun:new Date().getFullYear(),
           lat:0,
           lng:0,
       },
        initialForm:{
           id:0,
           kegiatan:'',
           jenis_kegiatan:'',
           alamat:'',
           sumber_dana_id:'0',
           anggaran:'',
           volume:'',
           pelaksana:'',
           tahun:new Date().getFullYear(),
           lat:0,
           lng:0,
       },
       sumberDana : [],
       errors:[],
       title:'',
       yearNow : new Date().getFullYear()
    };
  },
  beforeMount(){
  },
  mounted(){
     let params = JSON.parse((atob(this.$route.params.id)));
     Object.assign(this, params);
     this.form = this.initialForm;
     if(params.id != 0 ){
        this.kegiatanByID(params.id);
     }
     this.getSumberDana();
  },
  computed: {
    dynamicSize () {
      return [this.iconSize, this.iconSize * 1.15];
    },
    dynamicAnchor () {
      return [this.iconSize / 2, this.iconSize * 1.15];
    }
  },
  methods:{
        dragging(e){
           let data  = e.latlng;
           Object.assign(this.form, data);
        },
        kegiatanByID(id){
            axios.get(App.baseURL + '/get-kegiatanById/' + id,App.request).then(response => {
                if(response.data.success){
                  let data = response.data.result;
                  Object.assign(this.form, data);
                  this.center = data.marker;
                }
            }).catch(error=>{

            })
        },
        getSumberDana(){
            axios.get(App.baseURL + '/get-sumber-dana-all',App.request).then(response => {
                if(response.data.success){
                    this.sumberDana = response.data.results
                }
                else{
                     Swal.fire('Informasi', 'Ada Kesalahan Server' ,'error');
                }
            }).catch(error=>{
                 Swal.fire('Informasi', 'Ada Kesalahan Server' ,'error');
            });
        },
        simpan(){
            var config = {
              headers: {
                'Access-Control-Allow-Origin': '*',
                'Content-Type': 'application/json',
              },
            }
            axios.post(App.baseURL + '/simpan-kegiatan-fisik', this.form,App.request).then(
                Response=>{
                    if(Response.data.success){
                      Swal.fire('Informasi', Response.data.msg, 'success');
                      this.$router.push({name: 'kegiatan_fisik'});
                    }
                }).catch( error =>{
                     if (error.response.status == 422){
                        this.errors = error.response.data.errors;
                        }
                });
        }
  }
}
</script>