import React from 'react';
import { Link } from 'react-router-dom';
import { ListItem, ListItemIcon, ListItemText } from '@material-ui/core';

const ListItemLink = (props) => {
    const { icon, primary, to } = props;

    const CustomLink = React.forwardRef((props, ref) => <Link to={to} innerRef={ref} {...props} />);

    return (
        <ListItem component={CustomLink}>
            <ListItemIcon>{icon}</ListItemIcon>
            <ListItemText primary={primary} />
        </ListItem>
    );
}

export default ListItemLink;