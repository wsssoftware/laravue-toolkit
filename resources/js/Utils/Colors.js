

export function LightenDarkenColor(color, amount) {

    let usePound = false;

    if (color[0] == "#") {
        color = color.slice(1);
        usePound = true;
    }

    let number = parseInt(color,16);

    let red = (number >> 16) + amount;

    if (red > 255) red = 255;
    else if  (red < 0) red = 0;

    let blue = ((number >> 8) & 0x00FF) + amount;

    if (blue > 255) blue = 255;
    else if  (blue < 0) blue = 0;

    let green = (number & 0x0000FF) + amount;

    if (green > 255) green = 255;
    else if (green < 0) green = 0;

    return (usePound?"#":"") + (green | (blue << 8) | (red << 16)).toString(16);

}
