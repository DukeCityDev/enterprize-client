import axios from 'axios';
export const GET_SCON = 'GET_SCON';

const rootUrl = "https://sconsdocdev.unm.edu/public_html/api";



export const getScon = ()=>{
    return async function(dispatch,getState){

        await axios.get(`${rootUrl}/scon`)
            .then(result=>{
                dispatch({type : GET_SCON, payload : result.data});
            })
            .catch(error=>{
                dispatch({type : GET_SCON,payload : {error}})
        });

    }
};