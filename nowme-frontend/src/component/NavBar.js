import React from 'react';
import { Link, NavLink } from 'react-router-dom';
import { makeStyles } from '@material-ui/core/styles';
import AppBar from '@material-ui/core/AppBar';
import Toolbar from '@material-ui/core/Toolbar';
import Typography from '@material-ui/core/Typography';
import IconButton from '@material-ui/core/IconButton';
import MenuIcon from '@material-ui/icons/Menu';
import AccountCircle from '@material-ui/icons/AccountCircle';
import MenuItem from '@material-ui/core/MenuItem';
import Menu from '@material-ui/core/Menu';
import { Divider } from '@material-ui/core';

const useStyles = makeStyles((theme) => ({
  root: {
    flexGrow: 1,
  },
  menuButton: {
    marginRight: theme.spacing(2),
  },
  title: {
    flexGrow: 1,
  },
  link: {
    color: "#000000",
    textDecoration: 'none',
  },
  navlink: {
    color: "#ffffff",
    textDecoration: 'none',
    '&:hover': {
      color: "#888888"
    }
  },
}));

const NavBar = (props) => {
  const classes = useStyles();
  const [auth] = React.useState(false);
  const [anchorEl, setAnchorEl] = React.useState(null);
  const open = Boolean(anchorEl);

  const handleMenu = (event) => {
    setAnchorEl(event.currentTarget);
  };

  const handleClose = () => {
    setAnchorEl(null);
  };

  return (
    <div className={classes.root}>
      <AppBar position="static">
        <Toolbar>
          <IconButton edge="start" className={classes.menuButton} color="inherit" aria-label="menu">
            <MenuIcon />
          </IconButton>
          <Typography variant="h6" className={classes.title}>
            <NavLink to={"/"} className={classes.navlink} exact={true}>Home</NavLink>
          </Typography>
          <div>
            <IconButton
              aria-label="account of current user"
              aria-controls="menu-appbar"
              aria-haspopup="true"
              onClick={handleMenu}
              color="inherit"
            >
              <AccountCircle />
            </IconButton>
            <Menu
              id="menu-appbar"
              anchorEl={anchorEl}
              anchorOrigin={{
                vertical: 'top',
                horizontal: 'right',
              }}
              keepMounted
              transformOrigin={{
                vertical: 'top',
                horizontal: 'right',
              }}
              open={open}
              onClose={handleClose}
            >
              {auth ?
              <>
                <MenuItem onClick={handleClose}><Link to="/profile" className={classes.link}>Profile</Link></MenuItem>
                <Divider variant="middle" />
                <MenuItem onClick={handleClose}>Logout</MenuItem>
              </>
              :
              <>
                <MenuItem onClick={handleClose}><Link to="/signin" className={classes.link}>SignIn</Link></MenuItem>
                <Divider variant="middle" />
                <MenuItem onClick={handleClose}><Link to="/signup" className={classes.link}>SignUp</Link></MenuItem>
              </>
              } 
            </Menu>
          </div>
        </Toolbar>
      </AppBar>
    </div>
  );
}

export default NavBar;