import React from 'react';
import { makeStyles } from '@material-ui/core/styles';
import { Container, Card, CardContent, Typography, Button } from '@material-ui/core'
import {useHistory} from 'react-router-dom';

const useStyles = makeStyles({
    root: {
      minWidth: 275,
      marginTop: "10px",
      textAlign: 'center',
    },
  });

const Logout = (props) => {
    const classes = useStyles();

    const history = useHistory();

    const handleClickLogout = () => {
        props.setToken(null);
        history.push('/');
    }

    return(
        <Container component="main" maxWidth="md">
            <Card className={classes.root} variant="outlined">
                <CardContent>
                    <Typography variant="h3">
                        <Button variant="contained" color="primary" onClick={handleClickLogout}>
                            Logout
                        </Button>
                    </Typography>
                </CardContent>
            </Card>
        </Container>
    )
}

export default Logout;