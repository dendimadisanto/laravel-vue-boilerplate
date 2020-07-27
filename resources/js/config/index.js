module.exports = {
    baseURL : process.env.MIX_APP_URL,
    request : {
        headers:{
            Authorization : 'Basic ' + btoa(process.env.MIX_AUTH_USER + ':' + process.env.MIX_AUTH_PASS),
        },
    },
}