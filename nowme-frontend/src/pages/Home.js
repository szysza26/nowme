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

const Home = (props) => {
    const classes = useStyles();

    return(
        <Container component="main" maxWidth="md">
            <Card className={classes.root} variant="outlined">
                <CardContent>
                    <Typography variant="h3">
                        Token: {props.token}
                    </Typography>
                </CardContent>
            </Card>
        </Container>
    )
}

export default Home;