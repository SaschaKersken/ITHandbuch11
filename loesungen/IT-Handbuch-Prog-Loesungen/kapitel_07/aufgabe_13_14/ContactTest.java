import java.util.Set;
import java.util.HashSet;

public class ContactTest {
    public static void main(String[] args) {
        Set<Contact> contacts = new HashSet<>();
        contacts.add(new Contact("Peter", "Schmitz", "ps@example.com", "0151/111222"));
        contacts.add(new Contact("Lisa", "Müller", "lm@example.com", "0151/222333"));
        contacts.add(new Contact("Giovanni", "Castello", "gc@example.com", "0151/333444"));
        contacts.add(new Contact("Setsuko", "Yamada", "sy@example.com", "0151/444555"));
        for (var contact: contacts) {
            System.out.println(contact);
        }
    }
}
