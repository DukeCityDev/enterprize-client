import axios from 'axios';
export const GET_SCON = 'GET_SCON';

const rootUrl = "https://sconsdocdev.unm.edu/public_html/api";



export function getScon(){
    const request = axios.get(`${rootUrl}/scon`);
    return{
        type: GET_SCON,
        payload: request
    }
}