import React,{Component} from "react";
import {ListItemIcon,ListItemText,ListItem,IconButton,Toolbar,Button,AppBar,Drawer,List,Divider} from "@material-ui/core";
import MenuIcon from '@material-ui/icons/Menu';
import AccountCircle from '@material-ui/icons/AccountCircle';
import SendIcon from '@material-ui/icons/Send';

export default class NavigationBar extends Component{

    constructor(props){
        super(props);

        this.state = {
          sideMenuOpened: false
        };
    }

    styles = {
        drawer:{
            //width : "30vw",
        },
        listItem:{
            textAlign:"center"
        }
    };

    sideMenuOpen = ()=>{
        console.log("menu opened");
        this.setState({sideMenuOpened: true});
    };

    sideMenuClose = ()=>{
        console.log("menu closed");
        this.setState({sideMenuOpened: false});
    };

    render(){
        const {sideMenuOpened} = this.state;
        let sideMenuOpen = this.sideMenuOpen.bind(this);
        let sideMenuClose = this.sideMenuClose.bind(this);
        return (
            <AppBar position={"static"} color={"primary"}>
                <Toolbar>
                    <IconButton onClick={sideMenuOpen} color="inherit" aria-label="Menu">
                        <MenuIcon />
                    </IconButton>
                </Toolbar>
                <Drawer open={sideMenuOpened} onClose={sideMenuClose}>
                    <div
                        tabIndex={0}
                        role="button"
                        onClick={sideMenuClose}
                        onKeyDown={sideMenuClose}
                    >
                        <div style={this.styles.drawer}>
                            <List>
                                <ListItem button>
                                    <ListItemIcon>
                                        <SendIcon/>
                                    </ListItemIcon>
                                    <ListItemText inset primary="My Shifts" />
                                </ListItem>
                                <ListItem button>
                                    <ListItemIcon>
                                        <SendIcon/>
                                    </ListItemIcon>
                                    <ListItemText inset primary="My Coverages"/>
                                </ListItem>
                                <ListItem button>
                                    <ListItemIcon>
                                        <SendIcon/>
                                    </ListItemIcon>
                                    <ListItemText inset primary="Pod Shifts" />
                                </ListItem>
                                <ListItem button>
                                    <ListItemIcon>
                                        <SendIcon/>
                                    </ListItemIcon>
                                    <ListItemText inset primary="Find Scon" />
                                </ListItem>
                                <ListItem button>
                                    <ListItemIcon>
                                        <SendIcon/>
                                    </ListItemIcon>
                                    <ListItemText inset primary="Open Coverages" />
                                </ListItem>
                                <ListItem button>
                                    <ListItemIcon>
                                        <SendIcon/>
                                    </ListItemIcon>
                                    <ListItemText inset primary="Open Giveaways" />
                                </ListItem>
                                <ListItem button>
                                    <ListItemIcon>
                                        <SendIcon/>
                                    </ListItemIcon>
                                    <ListItemText inset primary="Bug Tracker" />
                                </ListItem>
                                <ListItem button>
                                    <ListItemIcon>
                                        <SendIcon/>
                                    </ListItemIcon>
                                    <ListItemText inset primary="Sent mail" />
                                </ListItem>
                            </List>
                        </div>
                    </div>
                </Drawer>
            </AppBar>);
    }

}