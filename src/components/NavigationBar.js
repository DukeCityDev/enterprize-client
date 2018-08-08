import React,{Component} from "react";
import {ListItemText,ListItem,IconButton,Toolbar,Button,AppBar,Drawer,List,Divider} from "@material-ui/core";
import MenuIcon from '@material-ui/icons/Menu';
import AccountCircle from '@material-ui/icons/AccountCircle';


export default class NavigationBar extends Component{

    constructor(props){
        super(props);

        this.state = {
          sideMenuOpened: false
        };
    }

    styles = {
        drawer:{
            width : "30vw",
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
                    <IconButton color="inherit" aria-label="Menu">
                        <MenuIcon onClick={sideMenuOpen} />
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
                                <ListItem>
                                    <ListItemText inset primary="Sent mail" style={this.styles.listItem} />
                                </ListItem>
                                <ListItem>
                                    <ListItemText inset primary="Sent mail" style={this.styles.listItem}/>
                                </ListItem>
                                <ListItem>
                                    <ListItemText inset primary="Sent mail" style={this.styles.listItem}/>
                                </ListItem>
                                <ListItem>
                                    <ListItemText inset primary="Sent mail" style={this.styles.listItem}/>
                                </ListItem>
                            </List>
                            <Divider />
                            <List>
                                <ListItem>
                                    <ListItemText inset primary="Sent mail" style={this.styles.listItem}/>
                                </ListItem>
                                <ListItem>
                                    <ListItemText inset primary="Sent mail" style={this.styles.listItem}/>
                                </ListItem>
                                <ListItem>
                                    <ListItemText inset primary="Sent mail" style={this.styles.listItem} />
                                </ListItem>
                                <ListItem>
                                    <ListItemText inset primary="Sent mail" style={this.styles.listItem}/>
                                </ListItem>
                            </List>
                        </div>
                    </div>
                </Drawer>
            </AppBar>);
    }

}