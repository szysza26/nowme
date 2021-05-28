import React, {useState} from 'react';
import Avatar from '@material-ui/core/Avatar';
import Button from '@material-ui/core/Button';
import CssBaseline from '@material-ui/core/CssBaseline';
import TextField from '@material-ui/core/TextField';
import Grid from '@material-ui/core/Grid';
import LockOutlinedIcon from '@material-ui/icons/LockOutlined';
import Typography from '@material-ui/core/Typography';
import { makeStyles } from '@material-ui/core/styles';
import Container from '@material-ui/core/Container';
import axios from 'axios';
import {useHistory} from 'react-router-dom';

const useStyles = makeStyles((theme) => ({
  paper: {
    marginTop: theme.spacing(8),
    display: 'flex',
    flexDirection: 'column',
    alignItems: 'center',
  },
  avatar: {
    margin: theme.spacing(1),
    backgroundColor: theme.palette.secondary.main,
  },
  form: {
    width: '100%', // Fix IE 11 issue.
    marginTop: theme.spacing(1),
  },
  submit: {
    margin: theme.spacing(3, 0, 2),
  },
}));

const ResetPasswordForm = (props) => {
  const classes = useStyles();

  const history = useHistory();

  const [email, setEmail] = useState('');
  const [resetToken, setResetToken] = useState('');
  const [passwordFirst, setPasswordFirst] = useState('');
  const [passwordSecond, setPasswordSecond] = useState('');

  const handleChange = (event) => {
    switch(event.target.name){
        case 'email':
            setEmail(event.target.value);
            break;
        case 'resetToken':
            setResetToken(event.target.value);
            break;
        case 'passwordFirst':
            setPasswordFirst(event.target.value);
            break;
        case 'passwordSecond':
            setPasswordSecond(event.target.value);
            break;
        default:
            console.log('can not handle this value');
    }
  }

  const send = () => {

    let axiosConfig = {
      headers: {
          "Content-Type": 'application/json',
      }
    };

    let data = {
      "email": email,
    }

    axios.post("https://api.szysza.ovh/api/reset-password", data, axiosConfig)
      .then((res) => {
        setEmail('');
        console.log(res);
      })
      .catch((error) => {
        console.log(error);
      })
  }

  const changePassword = () => {
    let axiosConfig = {
      headers: {
        "Content-Type": 'application/json',
      }
    };

    let data = {
      "email": email,
    }

    axios.post(`https://api.szysza.ovh/api/reset-password/${resetToken}`, data, axiosConfig)
        .then((res) => {
          console.log(res);
          history.push('/siginin');
        })
        .catch((error) => {
          console.log(error);
        })
  }

  return (
    <Container component="main" maxWidth="xs">
      <CssBaseline />
      <div className={classes.paper}>
        <Avatar className={classes.avatar}>
          <LockOutlinedIcon />
        </Avatar>
        <Typography component="h1" variant="h5">
          Get Token
        </Typography>
        <form className={classes.form} noValidate >
          <TextField
            variant="outlined"
            margin="normal"
            required
            fullWidth
            id="email"
            label="Email"
            name="email"
            autoFocus
            value={email}
            onChange={handleChange}
          />
          <Button
            fullWidth
            variant="contained"
            color="primary"
            className={classes.submit}
            onClick={send}
          >
            Wyślij
          </Button>
        </form>
        <Typography component="h1" variant="h5">
          Reset Password
        </Typography>
        <form className={classes.form} noValidate >
          <TextField
              variant="outlined"
              margin="normal"
              required
              fullWidth
              id="resetToken"
              label="Token"
              name="resetToken"
              autoFocus
              value={resetToken}
              onChange={handleChange}
          />
          <Grid item xs={12}>
            <TextField
                variant="outlined"
                required
                fullWidth
                name="passwordFirst"
                label="Password"
                type="password"
                id="passwordFirst"
                value={passwordFirst}
                onChange={handleChange}
            />
          </Grid>
          <Grid item xs={12}>
            <TextField
                variant="outlined"
                required
                fullWidth
                name="passwordSecond"
                label="Password"
                type="password"
                id="passwordSecond"
                value={passwordSecond}
                onChange={handleChange}
            />
          </Grid>
          <Button
              fullWidth
              variant="contained"
              color="primary"
              className={classes.submit}
              onClick={changePassword}
          >
            Zmień
          </Button>
        </form>
      </div>
    </Container>
  );
}

export default ResetPasswordForm;