import axios from 'axios';
export const GET_SCON = 'GET_SCON';
export const GET_ALL_SCONS = 'GET_ALL_SCONS';
export const GET_SHIFTS = 'GET_SHIFTS';
export const GET_PODS = 'GET_PODS';
const rootUrl = "/sconsdocdev/public_html/api";



export const getScon = ()=>{
    return async function(dispatch,getState){

        await axios.get(`/sconsdocdev/public_html/api/Scon`)
            .then(result=>{
                dispatch({type : GET_SCON, payload : result.data});
            })
            .catch(error=>{
                dispatch({type : GET_SCON,payload : {error}})
        });

    }
};

export const getShiftsByShiftPlanName = (shiftPlanName : string)=>{
    return async function(dispatch,getState){
        await axios.get(`${rootUrl}/Shift?ShiftPlanName=${shiftPlanName}&findMethod=shiftPlanName`)
            .then(result=>{
                let scheduleArray = [];
                if(result.data.data){
                    scheduleArray = Object.keys(result.data.data).map((key)=>{
                        return result.data.data[key];
                    });
                }
                dispatch({type : GET_SHIFTS, payload : scheduleArray});
            })
            .catch(error=>{
                dispatch({type : GET_SHIFTS,payload : {error}})
            });
    }
};

export const getAllPods = () => {
    return async function(dispatch,getState){
        await axios.get(`${rootUrl}/pod`)
            .then(result=>{

                let podArray = [];
                if(result.data.data){
                    podArray = Object.keys(result.data.data).map((key)=>{
                        return result.data.data[key];
                    });
                }
                dispatch({type : GET_PODS, payload : podArray});
            })
            .catch(error=>{
                dispatch({type : GET_PODS,payload : {error}})
            });
    }
};

export const getAllScons = () => {
    return async function(dispatch,getState){
        await axios.get(`${rootUrl}/Scon?findMethod=all`)
            .then(result=>{

                let sconArray = [];
                if(result.data.data){
                    sconArray = Object.keys(result.data.data).map((key)=>{
                        return result.data.data[key];
                    });
                }
                dispatch({type : GET_ALL_SCONS, payload: sconArray});
            })
            .catch(error=>{
                dispatch({type : GET_ALL_SCONS,payload : {error}})
            });
    }
};