export default module => {
    console.log('module', module);

    const variable = 'variable';

    const expression = () => {
        console.log('expression', variable);
    };

    expression();
};
