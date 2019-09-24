import React from 'react';
import ReactDOM from 'react-dom';
import { Provider } from 'react-redux';
import { createStore, applyMiddleware } from 'redux';
import { BrowserRouter, Route, Switch } from 'react-router-dom';
import thunk from 'redux-thunk';
import reducers from './reducers';
import Home from "./components/Home";
import '../styles/main.scss';
import PodSchedule from "./components/PodSchedule";
import WeekdaySchedule from "./components/WeekdaySchedule";
import Scons from "./components/Scon/Scons";
import MakeSchedule from "./components/MakeSchedule";
//test
const store = createStore(reducers,applyMiddleware(thunk));

// just for testing


ReactDOM.render(

    <Provider store={store}>
        <BrowserRouter>
            <div>
                <Switch>
                    <Route exact path="/weekday" component={WeekdaySchedule} />
                </Switch>
                <Switch>
                    <Route exact path="/pods" component={PodSchedule} />
                </Switch>
                <Switch>
                    <Route exact path="/scons" component={Scons} />
                </Switch>
                <Switch>
                    <Route exact path="/make-schedule" component={MakeSchedule} />
                </Switch>
                <Switch>
                    <Route exact path="/sconsdocdev" component={Home} />
                </Switch>
            </div>
        </BrowserRouter>
    </Provider>
    ,
    document.getElementById('root') as HTMLElement
);
//registerServiceWorker();

