export const apiSupplier = {
    get,
    save,
    getById
}

function get(payload){
    return new Promise((resolve, reject) => {
        axios.get(App.baseURL + '/get-supplier?page=' + payload,App.request).then(response =>{
            resolve(response.data);
        }).catch(error=>{
            reject(error);
        })
    })
}

function save(payload){
    return new Promise((resolve, reject)=>{
        axios.post(App.baseURL + '/saveSupplier', payload ,App.request ).then(response=>{
            resolve(response.data);
        }).catch(error=>{
            reject(error);
        })
    })
}

function getById(payload){
    return new Promise((resolve, reject)=>{
        axios.post(App.baseURL + '/getSupplierById', {id:payload}, App.request).then(response=>{
            resolve(response.data);
        }).catch(error=>{
            reject(error);
        })
    })
}