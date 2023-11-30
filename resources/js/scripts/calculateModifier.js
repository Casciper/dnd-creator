export default function calculateModifier(value) {
    const modifiers = {
        '-5': [0, 1],
        '-4': [2, 3],
        '-3': [4, 5],
        '-2': [6, 7],
        '-1': [8, 9],
        '0': [10, 11],
        '1': [12, 13],
        '2': [14, 15],
        '3': [16, 17],
        '4': [18, 19],
        '5': [20, 21],
        '6': [22, 23],
        '7': [24, 25],
        '8': [26, 27],
        '9': [28, 29],
        '10': [30, Infinity],
    };

    for (const modifier in modifiers) {
        const [min, max] = modifiers[modifier];
        if (value >= min && value <= max) {
            return parseInt(modifier);
        }
    }

    return null;
}
