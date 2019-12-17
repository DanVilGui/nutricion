package fuzzy;

public class Entrada {

    public String salida;
    public String nombre;
    public double entrada;
    public Modelo[] fus;

    public Entrada(String nombre, Modelo[] ms) {
        this.nombre = nombre;
        this.fus = ms;
    }

    public double getEntrada() {
        return entrada;
    }

    public void setEntrada(double entrada) {
        this.entrada = entrada;

    }

    public void procesar() {
        double mayor = Double.MIN_VALUE;
        System.out.println("PROCESANDO VARIABLE " + nombre);
        for (Modelo f : fus) {
            String str = "";
            if (f.pertenece(entrada)) {
                str += f.nombre + " : ";
                double valor = f.funcion(entrada);
                str += String.valueOf(valor);
                System.out.println(str);
                if (valor > mayor) {
                    mayor = valor;
                    salida = f.nombre;
                }
            }

        }

        System.out.println(" ----> Salida " + salida + " : " + String.valueOf(mayor));

    }

    public Modelo[] getFus() {
        return fus;
    }

    public void setFus(Modelo[] fus) {
        this.fus = fus;
    }

}
