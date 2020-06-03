import AppStorage from "./AppStorage";

class User {


    login(data){
       axios.post('/api/login', data)
            .then(response => {
                AppStorage.store(response.data.data.userName, response.data.data.token);
                // return response.data;
                window.console.log('Response Login: ', response.data);
                // loginResponse = response.data;
            })
            .catch(error => {
                const loginResponse = error.response.data;
                // return error.response.data
                window.console.log('Error Login: ', loginResponse);
                return loginResponse;
                // loginResponse = error.response.data;
            });
    }


    hasToken(){
        const storedToken = AppStorage.getToken();
        window.console.log('TOKEN z hasToken: ',storedToken);
        return !!storedToken;
    }

    isLogin(){
        return this.hasToken();
    }

    logout(){
        AppStorage.clear();
    }

    name(){
        // if(this.loggedIn()){
            return AppStorage.getUser();
        // }
    }
}

export default User = new User();
