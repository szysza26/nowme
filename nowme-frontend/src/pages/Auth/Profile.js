import React from 'react';
import { makeStyles } from '@material-ui/core/styles';
import { Container, Card, CardContent, Typography } from '@material-ui/core'

const useStyles = makeStyles({
    root: {
      minWidth: 275,
      marginTop: "10px",
      textAlign: 'center',
    },
  });

const Profile = (props) => {
    const classes = useStyles();

    return(
        <Container component="main" maxWidth="md">
            <Card className={classes.root} variant="outlined">
                <CardContent>
                    <Typography variant="h3">
                        {"Witaj " + props.token.username}
                    </Typography>
                    <Typography variant="h5">
                        {"Role: " + props.token.roles}
                    </Typography>
                    <Typography variant="h5">
                        {"Token ważny do: " + new Date(props.token.exp * 1000).toLocaleString()}
                    </Typography>
                </CardContent>
            </Card>
        </Container>
    )
}

export default Profile;