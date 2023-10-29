const useAxios = (url, params) => {
    axios.post('/api/admin/isLogin', {'token':sessionStorage.getItem('token')})
    .then(response => {
        if(response.data['user'] != sessionStorage.getItem('username') || response.data['user'] == ''){
            location.href="/adminLogout";
        }
    });
    return axios.post(url, params);
}