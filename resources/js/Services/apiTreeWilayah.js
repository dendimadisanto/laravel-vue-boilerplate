export const apiTreeWilayah = {
    get,
    save,
    getById,
    del
}

function get(payload){
    return new Promise((resolve, reject) => {
        axios.post(App.baseURL + '/get-tree-wilayah', payload, App.request ).then(response =>{
            resolve(response.data);
        }).catch(error=>{
            reject(error);
        })
    })
}

function save(payload){
    return new Promise((resolve, reject)=>{
        axios.post(App.baseURL + '/saveRegion', payload, App.request).then(response=>{
            resolve(response.data);
        }).catch(error=>{
            reject(error);
        })
    })
}

function getById(payload){
    return new Promise((resolve, reject)=>{
        axios.post(App.baseURL + '/getRegionById',payload, App.request ).then(response=>{
            resolve(response.data);
        }).catch(error=>{
            reject(error);
        })
    })
}

function del(payload){
    return new Promise((resolve, reject)=>{
        axios.post(App.baseURL + '/delRegion', payload, App.request).then(response=>{
            resolve(response.data);
        }).catch(error=>{
            reject(error);
        })
    })
}