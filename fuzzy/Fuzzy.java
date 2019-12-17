package fuzzy;

public class Fuzzy {

    public static void main(String[] args) {

        Modelo[] pA = new Modelo[]{new Trapezoide("BAJA", 10, 10, 30, 40),
            new Triangulo("MEDIA", 30, 50, 70),
            new Trapecio("ALTA", 60, 80, 100, 100)};
        Entrada pasesA = new Entrada("PASES A", pA);
        pasesA.setEntrada(35);

        Modelo[] pB = new Modelo[]{new Trapezoide("BAJA", 10, 10, 20, 40),
            new Triangulo("MEDIA", 30, 50, 70),
            new Trapecio("ALTA", 60, 90, 100, 100)};
        Entrada pasesB = new Entrada("PASES B", pB);
        pasesB.setEntrada(55);

        System.out.println("VARIABLES DE ENTRADA : ");

        System.out.println("VARIABLE " + pasesA.nombre + " : " + pasesA.getEntrada());
        System.out.println("VARIABLE " + pasesB.nombre + " : " + pasesB.getEntrada());

        
        pasesA.procesar();
        pasesB.procesar();
        
        System.out.println("RESULTADO : ");
        if (pasesA.salida.equals("BAJA") && pasesB.salida.equals("BAJA")) {
            System.out.println("PB_NULO");
        } else if (pasesB.salida.equals("BAJA") || pasesA.salida.equals("ALTA")) {
            System.out.println("PB_POSICION_A");
        } else if (pasesB.salida.equals("ALTA") || pasesB.salida.equals("MEDIA")) {
            System.out.println("PB_POSICION_B");

        }

    }

}
