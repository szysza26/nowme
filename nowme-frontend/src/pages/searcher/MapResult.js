import React, {useState} from 'react';
import {makeStyles} from "@material-ui/core/styles";
import {Paper, Box, Typography} from "@material-ui/core";
import { MapContainer, TileLayer, Marker, Popup } from 'react-leaflet'
import 'leaflet/dist/leaflet.css';

import L from 'leaflet';
import icon from 'leaflet/dist/images/marker-icon.png';
let DefaultIcon = L.icon({
    iconUrl: icon
});
L.Marker.prototype.options.icon = DefaultIcon;

const useStyles = makeStyles({
    paper: {
        padding: '8px',
        marginBottom: '10px',
    },
    root: {
        height: "400px",
        width: "100%",
    }
});

const MapResult = (props) => {
    const classes = useStyles();

    const result = props.result;

    const renderMarkers = () => {
        return result.map(element =>
                <Marker
                    key={element.office.name}
                    position={[element.office.lat, element.office.lng]}
                >
                    <Popup>
                        {element.office.name}
                    </Popup>
                </Marker>
            )
    }

    return (
        <>
            <Paper className={classes.paper}>
                <MapContainer center={[53.43, 14.57]} zoom={12} scrollWheelZoom={false} className={classes.root}>
                    <TileLayer
                        attribution='&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
                        url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
                    />
                    {/*{result && renderMarkers()}*/}
                </MapContainer>
            </Paper>
        </>
    );
}

export default MapResult;